<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Support\Carbon;

class QET
{
    public function get(string $date)
    {
        // $startDate = Carbon::createFromFormat('Y-m-d', $date);
        // $endDate = Carbon::createFromFormat('Y-m-d', $date);

        // $startDate->setTime(0, 0, 0, 0)->setTimezone('UTC');
        // $endDate->setTime(0, 0, 0, 0)->setTimezone('UTC')->addDays(2);

        // $headers = [
        //     'X-AUTH-TOKEN' => config('app.current_rms.auth_token'),
        //     'X-SUBDOMAIN' => config('app.current_rms.subdomain'),
        // ];

        // $client = new Client([
        //     'base_uri' => config('app.current_rms.host'),
        //     'headers' => $headers,
        // ]);

        // $promises = [
        //     'load' => $client->getAsync('opportunities', [
        //         'query' => [
        //             'per_page' => 25,
        //             'q[load_starts_at_gteq]' => $startDate->format('Y-m-d'),
        //             'q[load_ends_at_lt]' => $endDate->format('Y-m-d'),
        //             'include[]' => 'opportunity_items',
        //         ]
        //     ]),
        //     'unload' => $client->getAsync('opportunities', [
        //         'query' => [
        //             'per_page' => 25,
        //             'q[unload_starts_at_gteq]' => $startDate->format('Y-m-d'),
        //             'q[unload_ends_at_lt]' => $endDate->format('Y-m-d'),
        //             'include[]' => 'opportunity_items',
        //         ]
        //     ]),
        // ];

        // try {
        //     $responses = Promise\Utils::unwrap($promises);
        // } catch (\Throwable $th) {
        //     // RETURN ERROR
        // }

        // $jobsToLoad = [];
        // $jobsToUnload = [];

        // foreach ($responses as $key => $response) {
        //     $res = json_decode($response->getBody(), true);

        //     switch ($key) {
        //         case 'load':
        //             $jobsToLoad = $res['opportunities'];
        //             break;
        //         case 'unload':
        //             $jobsToUnload = $res['opportunities'];
        //             break;
        //         default:
        //             break;
        //     }
        // }

        // if (empty($jobsToLoad) || empty($jobsToUnload)) {
        //     // RETURN EMPTY RESPONSE
        // }

        // $qet = [];
        // $itemsToLoad = [];
        // $itemsToUnload = [];

        // foreach ($jobsToLoad as $load) {
        //     $items = array_values(array_filter($load['opportunity_items'], function ($item) {
        //         return $item['item_id'] !== null && $item['has_shortage'] === true && $item['accessory_mode'] === null;
        //     }));

        //     if (empty($items)) {
        //         continue;
        //     }

        //     $itemsToLoad = [
        //         ...$itemsToLoad,
        //         ...array_map(function ($itemToLoad) use ($load) {
        //             return [
        //                 'item_id' => $itemToLoad['item_id'],
        //                 'name' => $itemToLoad['name'],
        //                 'quantity' => intval($itemToLoad['quantity']),
        //                 'job' => [
        //                     'subject' => $load['subject'],
        //                     'load_starts_at' => $load['load_starts_at'],
        //                 ],
        //             ];
        //         }, $items)
        //     ];
        // }

        // foreach ($jobsToUnload as $unload) {
        //     $items = array_values(array_filter($unload['opportunity_items'], function ($item) {
        //         return $item['item_id'] !== null && $item['accessory_mode'] === null;
        //     }));

        //     if (empty($items)) {
        //         continue;
        //     }

        //     $itemsToUnload = [
        //         ...$itemsToUnload,
        //         ...array_map(function ($itemToUnload) use ($unload) {
        //             return [
        //                 'item_id' => $itemToUnload['item_id'],
        //                 'name' => $itemToUnload['name'],
        //                 'quantity' => intval($itemToUnload['quantity']),
        //                 'job' => [
        //                     'subject' => $unload['subject'],
        //                     'unload_ends_at' => $unload['unload_ends_at'],
        //                 ],
        //             ];
        //         }, $items)
        //     ];
        // }

        // if (empty($itemsToLoad) || empty($itemsToUnload)) {
        //     // RETURN EMPTY RESPONSE
        // }

        $itemsToLoad = [
            [
                "item_id" => 830,
                "name" => "EXE Rise 500kg Chain Hoist D8 Plus Double Break 4m/min 20m",
                "quantity" => 7,
                "job" => [
                    "subject" => "Niall Horan - Australian Tour 2024 > Production lighting hire",
                    "load_starts_at" => "2024-04-24T23:00:00.000Z",
                ],
            ],
            [
                "item_id" => 846,
                "name" => "Chain Motor Controller (8 way)",
                "quantity" => 1,
                "job" => [
                    "subject" => "Niall Horan - Australian Tour 2024 > Production lighting hire",
                    "load_starts_at" => "2024-04-24T23:00:00.000Z",
                ],
            ],
            [
                "item_id" => 830,
                "name" => "EXE Rise 500kg Chain Hoist D8 Plus Double Break 4m/min 20m",
                "quantity" => 4,
                "job" => [
                    "subject" => "Niall Horan - Australian Tour 2024 > Production lighting hire",
                    "load_starts_at" => "2024-04-24T23:00:00.000Z",
                ],
            ],
            [
                "item_id" => 2080,
                "name" => "MPH Pre-rig 3.0m Touring Truss Black c/w Dolley v3",
                "quantity" => 8,
                "job" => [
                    "subject" => "Niall Horan - Australian Tour 2024 > Production lighting hire",
                    "load_starts_at" => "2024-04-24T23:00:00.000Z",
                ],
            ],
            [
                "item_id" => 830,
                "name" => "EXE Rise 500kg Chain Hoist D8 Plus Double Break 4m/min 20m",
                "quantity" => 7,
                "job" => [
                    "subject" => "Niall Horan - Australian Tour 2024 > Production lighting hire",
                    "load_starts_at" => "2024-04-24T23:00:00.000Z",
                ],
            ],
            [
                "item_id" => 1535,
                "name" => "FireFly Festoon 20m - Warm White",
                "quantity" => 6,
                "job" => [
                    "subject" => "Niall Horan - Australian Tour 2024 > Production lighting hire",
                    "load_starts_at" => "2024-04-24T23:00:00.000Z",
                ],
            ],
        ];

        $itemsToUnload = [
            [
                "item_id" => 830,
                "name" => "EXE Rise 500kg Chain Hoist D8 Plus Double Break 4m/min 20m",
                "quantity" => 3,
                "job" => [
                    "subject" => "Niall Horan - Australian Tour 2024 > Production lighting hire",
                    "unload_ends_at" => "2024-04-24T23:00:00.000Z",
                ],
            ],
            [
                "item_id" => 846,
                "name" => "Chain Motor Controller (8 way)",
                "quantity" => 9,
                "job" => [
                    "subject" => "Niall Horan - Australian Tour 2024 > Production lighting hire",
                    "unload_ends_at" => "2024-04-24T23:00:00.000Z",
                ],
            ],
            [
                "item_id" => 830,
                "name" => "EXE Rise 500kg Chain Hoist D8 Plus Double Break 4m/min 20m",
                "quantity" => 4,
                "job" => [
                    "subject" => "Niall Horan - Australian Tour 2024 > Production lighting hire",
                    "unload_ends_at" => "2024-04-24T23:00:00.000Z",
                ],
            ],
        ];

        return [];
    }
}
