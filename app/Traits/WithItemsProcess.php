<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

trait WithItemsProcess
{
    private string $path = 'csv_files';

    private array $items = [];

    private array $requiredHeadings = ['id', 'quantity', 'group_name'];

    private array $existingGroups = [];

    private array $groups = [];

    private int $opportunityId = 0;

    private function processItems(array $job, string $filename)
    {
        $this->opportunityId = App::environment(['local', 'staging']) ? config('app.mph_test_opportunity_id') : $job['id'];
        $this->prepareItems($filename);
        $this->prepareExistingGroups($job);
        $this->prepareGroups();
        $this->maybeCreateNewGroups();

        return $this->storeItems($job);
    }

    private function prepareItems(string $filename): void
    {
        $headings = null;
        $items = [];

        if (($handle = fopen(base_path() . '/storage/app/' . $this->path . '/' . $filename, "r")) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($headings === null) {
                    $headings = $row;

                    // VALIDATE HEADINGS
                    $diff = array_diff($this->requiredHeadings, $headings);

                    if (count($diff) > 0) {
                        fclose($handle);
                        $this->deleteFile($filename);
                        $missingHeadings = Arr::join($diff, ', ', ' and ');
                        throw ValidationException::withMessages(['csvfile' => __('The uploaded csv file does not contain the valid headings required to identify the items. Missing headings: :missing_headings.', ['missing_headings' => $missingHeadings])]);
                    }

                    continue;
                }

                $items[] = array_combine($headings, $row);
            }
            fclose($handle);
        }

        $this->deleteFile($filename);
        $this->setItems($items);
    }

    private function deleteFile(string $filename)
    {
        Storage::delete($this->path . '/' . $filename);
    }

    private function setItems(array $items): void
    {
        $this->items = $items;
    }

    private function prepareExistingGroups(array $job): void
    {
        $existingGroups = array_values(
            array_map(
                fn ($group) => ['id' => $group['id'], 'name' => $group['name']],
                array_filter(
                    $job['opportunity_items'],
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
        $groupDiff = array_diff(
            $this->groups,
            array_map(fn ($group) => $group['name'], $this->existingGroups),
        );

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

        foreach ($responses as $response) {
            if ($response['state'] !== 'fulfilled') {
                continue;
            }

            $newGroup = json_decode($response['value']->getBody()->getContents(), true);
            $existingGroups[] = [
                'id' => $newGroup['opportunity_item']['id'],
                'name' => $newGroup['opportunity_item']['name'],
            ];
        }

        $this->setExistingGroups($existingGroups);
    }

    private function storeItems(array $job)
    {
        ['opportunity_items' => $opportunityItems] = $job;

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

                // ITEM EXISTS, DELETE IT, CHECK QUANTITY, RE-CREATE IT.
                $this->deleteItem($itemId);

                if ($quantity > 0) {
                    $this->createItem($item);
                }
            } else {
                // ITEM DOES NOT EXIST, CHECK QUANTITY AND CREATE IT.
                if ($quantity <= 0) {
                    continue;
                }

                $this->createItem($item);
            }
        }
    }

    private function createItem(array $item)
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

        return Http::current()->withQueryParameters($query)->post("opportunities/{$this->opportunityId}/opportunity_items");
    }

    private function deleteItem(int $itemId)
    {
        return Http::current()->delete("opportunities/{$this->opportunityId}/opportunity_items/{$itemId}");
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
