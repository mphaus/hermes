<?php

namespace App;

use App\Traits\WithHttpCurrentError;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class OpportunityItems
{
    use WithHttpCurrentError;

    protected array $opportunity;

    protected string $filename;

    protected int $opportunity_id = 0;

    protected string $path = 'csv_files';

    protected string $full_path;

    protected array $required_headings = ['id', 'item_name', 'quantity', 'group_name'];

    protected array $items = [];

    protected array $existing_groups = [];

    protected array $groups = [];

    protected array $log = [];

    protected array $diff = [];

    public function __construct(int $opportunity_id, string $filename)
    {
        $this->opportunity_id = App::environment(['local', 'staging']) ? config('app.mph.test_opportunity_id') : $opportunity_id;
        $this->filename = $filename;
        $this->diff = [
            'reduced' => [],
            'increased' => [],
            'removed' => [],
            'added' => [],
        ];
    }

    public function process()
    {
        $response = Http::current()->get("opportunities/{$this->opportunity_id}/?include[]=opportunity_items");

        if ($response->failed()) {
            return [
                'type' => 'error',
                'message' => $this->errorMessage(__('An error occurred while attempting to process the data from the uploaded file. Please refresh the page, and try again.'), $response->json()),
                'data' => [],
            ];
        }

        $this->opportunity = $response->json()['opportunity'];
        $this->full_path = base_path() . '/storage/app/' . $this->path . '/';

        $this->prepareItems();
        $this->prepareExistingGroups();
        $this->prepareGroups();
        $this->maybeCreateNewGroups();

        return $this->storeItems();
    }

    private function prepareItems(): void
    {
        $headings = null;
        $items = [];

        if (($handle = fopen($this->full_path . $this->filename, "r")) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($headings === null) {
                    $headings = $row;

                    // VALIDATE HEADINGS
                    $diff = array_diff($this->required_headings, $headings);

                    if (count($diff) > 0) {
                        fclose($handle);
                        $this->deleteFile();
                        $missingHeadings = Arr::join($diff, ', ', ' and ');
                        throw ValidationException::withMessages(['csv' => __('The uploaded csv file does not contain the valid headings required to identify the items. Missing headings: :missing_headings.', ['missing_headings' => $missingHeadings])]);
                    }

                    continue;
                }

                $items[] = array_combine($headings, $row);
            }
            fclose($handle);
        }

        $this->deleteFile();
        $this->setItems($items);
    }

    private function deleteFile(): void
    {
        Storage::delete($this->path . '/' . $this->filename);
    }

    private function setItems(array $items): void
    {
        $this->items = $items;
    }

    private function prepareExistingGroups(): void
    {
        $existing_groups = array_values(
            array_map(
                fn($group) => ['id' => $group['id'], 'name' => $group['name']],
                array_filter(
                    $this->opportunity['opportunity_items'],
                    fn($item) => $item['opportunity_item_type_name'] === 'Group'
                )
            )
        );

        $this->setExistingGroups($existing_groups);
    }

    private function setExistingGroups(array $groups): void
    {
        $this->existing_groups = $groups;
    }

    private function prepareGroups(): void
    {
        $groups = array_unique(
            array_map(
                fn($item) => $item['group_name'],
                $this->items
            )
        );

        $this->setGroups($groups);
    }

    private function setGroups(array $groups): void
    {
        $this->groups = $groups;
    }

    private function maybeCreateNewGroups(): void
    {
        $group_diff = array_values(array_diff(
            $this->groups,
            array_map(fn($group) => $group['name'], $this->existing_groups),
        ));

        if (count($group_diff) <= 0) {
            return;
        }

        $this->createGroups($group_diff);
    }

    private function createGroups(array $groups): void
    {
        $opportunity_id = $this->opportunity_id;
        $base_url = config('app.current_rms.host');
        $responses = Http::pool(fn(Pool $pool) => array_map(function ($group) use ($pool, $base_url, $opportunity_id) {
            $query = urldecode(http_build_query([
                'opportunity_item' => [
                    'opportunity_id' => $opportunity_id,
                    'opportunity_item_type_name' => 'Group',
                    'name' => $group,
                    'opportunity_item_type' => 0,
                    'source_id' => $opportunity_id,
                    'source_type' => 'Opportunity',
                ],
            ]));

            return $pool
                ->withHeaders([
                    'X-AUTH-TOKEN' => config('app.current_rms.auth_token'),
                    'X-SUBDOMAIN' => config('app.current_rms.subdomain'),
                ])
                ->post("{$base_url}opportunities/{$opportunity_id}/opportunity_items?{$query}");
        }, $groups));

        $existing_groups = $this->existing_groups;

        foreach ($responses as $key => $response) {
            if ($response->failed()) {
                $this->addToLog([
                    'item_id' => null,
                    'item_name' => $groups[$key],
                    'action' => 'creation',
                    'error' => [
                        'code' => $response->getStatusCode(),
                        'message' => $this->errorMessage($response->getReasonPhrase(), $response->json(), '. '),
                    ],
                ]);

                continue;
            }

            $new_group = $response->json();
            $existing_groups[] = [
                'id' => $new_group['opportunity_item']['id'],
                'name' => $new_group['opportunity_item']['name'],
            ];

            $this->addToLog([
                'item_id' => $new_group['opportunity_item']['id'],
                'item_name' => $new_group['opportunity_item']['name'],
                'action' => 'creation',
                'error' => [],
            ]);
        }

        $this->setExistingGroups($existing_groups);
    }

    private function storeItems(): array
    {
        ['opportunity_items' => $opportunity_items] = $this->opportunity;

        foreach ($this->items as $item) {
            // PREPARE ITEM DATA
            [
                'id' => $id,
                'quantity' => $quantity,
            ] = $item;

            $id = intval($id);
            $quantity = intval($quantity);

            // CHECK IF ITEM ALREADY EXISTS IN THE JOB
            $item_ids = array_column($opportunity_items, 'item_id');
            $index = array_search($id, $item_ids);

            if ($index) {
                $item_id = $opportunity_items[$index]['id'];

                // ITEM EXISTS, MAYBE DELETE IT OR CHECK QUANTITY, DELETE IT AND RE-CREATE IT.
                if ($quantity <= 0) {
                    $deletion = $this->deleteItem($item_id, $item);

                    if ($deletion) {
                        $this->addToDiff('removed', $item);
                    }
                } else {
                    $current_quantity = intval($opportunity_items[$index]['quantity']);

                    if ($quantity !== $current_quantity) {
                        $deletion = $this->deleteItem($item_id, $item, true);

                        if ($deletion) {
                            $creation = $this->createItem($item, true);

                            if ($creation) {
                                if ($quantity > $current_quantity) {
                                    $this->addToDiff('increased', $item, $quantity - $current_quantity);
                                } else {
                                    $this->addToDiff('reduced', $item);
                                }
                            }
                        }
                    }
                }
            } else {
                // ITEM DOES NOT EXIST, CHECK QUANTITY AND CREATE IT.
                if ($quantity <= 0) {
                    continue;
                }

                $creation = $this->createItem($item);

                if ($creation) {
                    $this->addToDiff('added', $item);
                }
            }
        }

        return [
            'log' => $this->log,
            'diff' => $this->diff,
        ];
    }

    private function createItem(array $item, bool $recreated = false): bool
    {
        [
            'id' => $id,
            'quantity' => $quantity,
            'group_name' => $group_name,
        ] = $item;

        $query = [
            'opportunity_item' => [
                'opportunity_id' => $this->opportunity_id,
                'item_id' => $id,
                'quantity' => $quantity,
                'price' => 0,
            ],
        ];

        // GET GROUP ID TO BE ADDED TO
        $groupIds = array_values(array_map(function ($group) {
            return $group['id'];
        }, array_filter($this->existing_groups, function ($group) use ($group_name) {
            return $group['name'] === $group_name;
        })));

        if (count($groupIds) > 0) {
            [$groupId] = $groupIds;
            $query['opportunity_item']['parent_opportunity_item_id'] = $groupId;
        }

        $response = Http::current()->withQueryParameters($query)->post("opportunities/{$this->opportunity_id}/opportunity_items");
        $action = $recreated ? 're-creation' : 'creation';

        if ($response->failed()) {
            $this->addToLog([
                'item_id' => $item['id'],
                'item_name' => $item['item_name'],
                'quantity' => intval($quantity),
                'action' => $action,
                'error' => [
                    'code' => $response->getStatusCode(),
                    'message' => $this->errorMessage($response->getReasonPhrase(), $response->json(), '. '),
                ],
            ]);

            return false;
        }

        $this->addToLog([
            'item_id' => $item['id'],
            'item_name' => $item['item_name'],
            'quantity' => intval($quantity),
            'action' => $action,
            'error' => [],
        ]);

        return true;
    }

    private function deleteItem(int $id, array $item, bool $recreation = false): bool
    {
        $response = Http::current()->delete("opportunities/{$this->opportunity_id}/opportunity_items/{$id}");
        $quantity = $recreation ? 0 : intval($item['quantity']);

        if ($response->failed()) {
            $this->addToLog([
                'item_id' => $item['id'],
                'item_name' => $item['item_name'],
                'quantity' => $quantity,
                'action' => 'deletion',
                'error' => [
                    'code' => $response->getStatusCode(),
                    'message' => $this->errorMessage($response->getReasonPhrase(), $response->json()),
                ],
            ]);

            return false;
        }

        $this->addToLog([
            'item_id' => $item['id'],
            'item_name' => $item['item_name'],
            'quantity' => $quantity,
            'action' => 'deletion',
            'error' => [],
        ]);

        return true;
    }

    private function addToLog(array $data)
    {
        $this->log[] = $data;
    }

    private function addToDiff(string $action, array $item, int $added_quantity = 0)
    {
        if ($action === 'increased') {
            $this->diff[$action][] = [
                ...$item,
                'added_quantity' => $added_quantity,
            ];

            return;
        }

        $this->diff[$action][] = $item;
    }
}
