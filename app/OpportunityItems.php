<?php

namespace App;

use App\Traits\WithHttpCurrentError;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class OpportunityItems
{
    use WithHttpCurrentError;

    protected array $job;

    protected string $filename;

    protected string $propertyName;

    protected int $opportunityId = 0;

    protected string $path = 'csv_files';

    protected string $fullPath;

    protected array $requiredHeadings = ['id', 'item_name', 'quantity', 'group_name'];

    protected array $items = [];

    protected array $existingGroups = [];

    protected array $groups = [];

    protected $log = [];

    public function process(array $job, string $filename)
    {
        $this->job = $job;
        $this->filename = $filename;
        $this->opportunityId = App::environment(['local', 'staging']) ? config('app.mph.test_opportunity_id') : $this->job['id'];
        $this->fullPath = base_path() . '/storage/app/' . $this->path . '/';

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

        if (($handle = fopen($this->fullPath . $this->filename, "r")) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($headings === null) {
                    $headings = $row;

                    // VALIDATE HEADINGS
                    $diff = array_diff($this->requiredHeadings, $headings);

                    if (count($diff) > 0) {
                        fclose($handle);
                        $this->deleteFile();
                        $missingHeadings = Arr::join($diff, ', ', ' and ');
                        throw ValidationException::withMessages(['item_process' => __('The uploaded csv file does not contain the valid headings required to identify the items. Missing headings: :missing_headings.', ['missing_headings' => $missingHeadings])]);
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
        $existingGroups = array_values(
            array_map(
                fn ($group) => ['id' => $group['id'], 'name' => $group['name']],
                array_filter(
                    $this->job['opportunity_items'],
                    fn ($item) => $item['opportunity_item_type_name'] === 'Group'
                )
            )
        );

        $this->setExistingGroups($existingGroups);
    }

    private function setExistingGroups(array $groups): void
    {
        $this->existingGroups = $groups;
    }

    private function prepareGroups(): void
    {
        $groups = array_unique(
            array_map(
                fn ($item) => $item['group_name'],
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
        $groupDiff = array_values(array_diff(
            $this->groups,
            array_map(fn ($group) => $group['name'], $this->existingGroups),
        ));

        if (count($groupDiff) <= 0) {
            return;
        }

        $this->createGroups($groupDiff);
    }

    private function createGroups(array $groups): void
    {
        $opportunityId = $this->opportunityId;
        $client = new Client(['base_uri' => config('app.current_rms.host')]);
        $promises = array_map(function ($group) use ($client, $opportunityId) {
            $headers = [
                'X-AUTH-TOKEN' => config('app.current_rms.auth_token'),
                'X-SUBDOMAIN' => config('app.current_rms.subdomain'),
            ];

            $query = [
                'opportunity_item' => [
                    'opportunity_id' => $opportunityId,
                    'opportunity_item_type_name' => 'Group',
                    'name' => $group,
                    'opportunity_item_type' => 0,
                ],
            ];

            return $client->postAsync("opportunities/{$opportunityId}/opportunity_items", [
                'headers' => $headers,
                'query' => $query,
            ]);
        }, $groups);

        $responses = Promise\Utils::settle($promises)->wait();
        $existingGroups = $this->existingGroups;

        foreach ($responses as $key => $response) {
            if ($response['state'] !== 'fulfilled') {
                $res = $response['reason']->getResponse();
                $errors = json_decode($res->getBody()->getContents(), true);

                $this->addToLog([
                    'item_id' => null,
                    'item_name' => $groups[$key],
                    'action' => 'creation',
                    'error' => [
                        'code' => $res->getStatusCode(),
                        'message' => $this->errorMessage($res->getReasonPhrase(), $errors, '. '),
                    ],
                ]);

                continue;
            }

            $newGroup = json_decode($response['value']->getBody()->getContents(), true);
            $existingGroups[] = [
                'id' => $newGroup['opportunity_item']['id'],
                'name' => $newGroup['opportunity_item']['name'],
            ];

            $this->addToLog([
                'item_id' => $newGroup['opportunity_item']['id'],
                'item_name' => $newGroup['opportunity_item']['name'],
                'action' => 'creation',
                'error' => [],
            ]);
        }

        $this->setExistingGroups($existingGroups);
    }

    private function storeItems(): array
    {
        ['opportunity_items' => $opportunityItems] = $this->job;

        foreach ($this->items as $item) {
            // PREPARE ITEM DATA
            [
                'id' => $id,
                'quantity' => $quantity,
            ] = $item;

            $id = intval($id);
            $quantity = intval($quantity);

            // CHECK IF ITEM ALREADY EXISTS IN THE JOB
            $itemIds = array_column($opportunityItems, 'item_id');
            $index = array_search($id, $itemIds);

            if ($index) {
                $itemId = $opportunityItems[$index]['id'];

                // ITEM EXISTS, MAYBE DELETE IT OR CHECK QUANTITY, DELETE IT AND RE-CREATE IT.
                if ($quantity <= 0) {
                    $this->deleteItem($itemId, $item);
                } else {
                    $currentQuantity = intval($opportunityItems[$index]['quantity']);

                    if ($quantity !== $currentQuantity) {
                        $deletion = $this->deleteItem($itemId, $item, true);

                        if ($deletion) {
                            $this->createItem($item, true);
                        }
                    }
                }
            } else {
                // ITEM DOES NOT EXIST, CHECK QUANTITY AND CREATE IT.
                if ($quantity <= 0) {
                    continue;
                }

                $this->createItem($item);
            }
        }

        return $this->log;
    }

    private function createItem(array $item, bool $recreated = false): bool
    {
        [
            'id' => $id,
            'quantity' => $quantity,
            'group_name' => $groupName,
        ] = $item;

        $query = [
            'opportunity_item' => [
                'opportunity_id' => $this->opportunityId,
                'item_id' => $id,
                'quantity' => $quantity,
                'price' => 0,
            ],
        ];

        // GET GROUP ID TO BE ADDED TO
        $groupIds = array_values(array_map(function ($group) {
            return $group['id'];
        }, array_filter($this->existingGroups, function ($group) use ($groupName) {
            return $group['name'] === $groupName;
        })));

        if (count($groupIds) > 0) {
            [$groupId] = $groupIds;
            $query['opportunity_item']['parent_opportunity_item_id'] = $groupId;
        }

        $response = Http::current()->withQueryParameters($query)->post("opportunities/{$this->opportunityId}/opportunity_items");
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
        $response = Http::current()->delete("opportunities/{$this->opportunityId}/opportunity_items/{$id}");
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

    // private function storeItems(array $job)
    // {
    //     $client = new Client(['base_uri' => config('app.current_rms.host')]);
    //     ['opportunity_items' => $opportunityItems] = $job;

    //     $promiseItems = array_filter(array_map(function ($item) use ($client, $opportunityItems) {
    //         // PREPARE ITEM DATA
    //         [
    //             'id' => $id,
    //             'quantity' => $quantity,
    //             'group_name' => $groupName,
    //         ] = $item;

    //         $id = intval($id);
    //         $quantity = intval($quantity);

    //         $headers = [
    //             'X-AUTH-TOKEN' => config('app.current_rms.auth_token'),
    //             'X-SUBDOMAIN' => config('app.current_rms.subdomain'),
    //         ];

    //         // CHECK IF ITEM ALREADY EXISTS IN THE JOB
    //         $itemIds = array_column($opportunityItems, 'item_id');
    //         $index = array_search($id, $itemIds);

    //         if ($index) {
    //             $itemId = $opportunityItems[$index]['id'];

    //             // ITEM EXISTS, CHECK QUANTITY, UPDATE IT OR DELETE IT.
    //             if ($quantity <= 0) {
    //                 return $this->prepareItemDelete($itemId, $headers, $client);
    //             } else {
    //                 return [
    //                     $this->prepareItemDelete($itemId, $headers, $client),
    //                     $this->prepareItemCreate($item, $headers, $client),
    //                 ];
    //             }
    //         } else {
    //             // ITEM DOES NOT EXIST, CHECK QUANTITY AND CREATE IT.
    //             if ($quantity <= 0) {
    //                 return false;
    //             }

    //             return $this->prepareItemCreate($item, $headers, $client);
    //         }
    //     }, $this->items));

    //     $promises = [];

    //     array_walk_recursive($promiseItems, function ($promiseItem) use (&$promises) {
    //         $promises[] = $promiseItem;
    //     });

    //     $responses = Promise\Utils::settle($promises)->wait();

    //     return $responses;
    // }

    // private function prepareItemCreate(array $item, array $headers, Client $client): \GuzzleHttp\Promise\PromiseInterface
    // {
    //     [
    //         'id' => $id,
    //         'quantity' => $quantity,
    //         'group_name' => $groupName,
    //     ] = $item;

    //     $query = [
    //         'opportunity_item' => [
    //             'opportunity_id' => $this->opportunityId,
    //             'item_id' => $id,
    //             'quantity' => $quantity,
    //             'price' => 0,
    //         ],
    //     ];

    //     // GET GROUP ID TO BE ADDED TO
    //     $groupIds = array_values(array_map(function ($group) {
    //         return $group['id'];
    //     }, array_filter($this->existingGroups, function ($group) use ($groupName) {
    //         return $group['name'] === $groupName;
    //     })));

    //     if (count($groupIds) > 0) {
    //         [$groupId] = $groupIds;
    //         $query['opportunity_item']['parent_opportunity_item_id'] = $groupId;
    //     }

    //     return $client->postAsync("opportunities/{$this->opportunityId}/opportunity_items", [
    //         'headers' => $headers,
    //         'query' => $query,
    //     ]);
    // }

    // private function prepareItemDelete(int $itemId, array $headers, Client $client): \GuzzleHttp\Promise\PromiseInterface
    // {
    //     return $client->deleteAsync("opportunities/{$this->opportunityId}/opportunity_items/{$itemId}", ['headers' => $headers]);
    // }
}
