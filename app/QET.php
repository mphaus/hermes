<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Support\Carbon;

class QET
{
    protected string $date = '';

    protected array $jobsToLoad = [];

    protected array $jobsToUnload = [];

    protected array $itemsToLoad = [];

    protected array $itemsToUnload = [];

    protected array $qet = [];

    public function get(string $date)
    {
        $this->date = $date;
        $responses = $this->getJobs();

        // Handle error from $responses if any

        // $this->setJobs($responses);

        // if (empty($this->jobsToLoad) || empty($this->jobsToUnload)) {
        //     // RETURN EMPTY RESPONSE
        // }

        $this->setItems();

        // if (empty($this->itemsToLoad) || empty($this->itemsToUnload)) {
        //     // RETURN EMPTY RESPONSE
        // }

        $this->setQET();

        return $this->qet;
    }

    private function getJobs(): array
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $this->date);
        $endDate = Carbon::createFromFormat('Y-m-d', $this->date);

        $startDate->setTime(0, 0, 0, 0)->setTimezone('UTC');
        $endDate->setTime(0, 0, 0, 0)->setTimezone('UTC')->addDays(2);

        $headers = [
            'X-AUTH-TOKEN' => config('app.current_rms.auth_token'),
            'X-SUBDOMAIN' => config('app.current_rms.subdomain'),
        ];

        $client = new Client([
            'base_uri' => config('app.current_rms.host'),
            'headers' => $headers,
        ]);

        $promises = [
            'load' => $client->getAsync('opportunities', [
                'query' => [
                    'per_page' => 25,
                    'q[load_starts_at_gteq]' => $startDate->format('Y-m-d'),
                    'q[load_ends_at_lt]' => $endDate->format('Y-m-d'),
                    'include[]' => 'opportunity_items',
                ]
            ]),
            'unload' => $client->getAsync('opportunities', [
                'query' => [
                    'per_page' => 25,
                    'q[unload_starts_at_gteq]' => $startDate->format('Y-m-d'),
                    'q[unload_ends_at_lt]' => $endDate->format('Y-m-d'),
                    'include[]' => 'opportunity_items',
                ]
            ]),
        ];

        try {
            $responses = Promise\Utils::unwrap($promises);
            return $responses;
        } catch (\Throwable $th) {
            // RETURN ERROR
        }
    }

    private function setJobs(array $responses): void
    {
        foreach ($responses as $key => $response) {
            $res = json_decode($response->getBody(), true);

            switch ($key) {
                case 'load':
                    $this->jobsToLoad = $res['opportunities'];
                    break;
                case 'unload':
                    $this->jobsToUnload = $res['opportunities'];
                    break;
                default:
                    break;
            }
        }
    }

    private function setItems(): void
    {
        // foreach ($this->jobsToLoad as $load) {
        //     $items = array_values(array_filter($load['opportunity_items'], function ($item) {
        //         return $item['item_id'] !== null && $item['has_shortage'] === true && $item['accessory_mode'] === null;
        //     }));

        //     if (empty($items)) {
        //         continue;
        //     }

        //     $this->itemsToLoad = [
        //         ...$this->itemsToLoad,
        //         ...array_map(function ($itemToLoad) use ($load) {
        //             return [
        //                 'item_id' => $itemToLoad['item_id'],
        //                 'name' => $itemToLoad['name'],
        //                 'quantity' => intval($itemToLoad['quantity']),
        //                 'job' => [
        //                     'subject' => $load['subject'],
        //                     'load_starts_at' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $load['load_starts_at'], 'UTC')->setTimezone(config('app.timezone')),
        //                 ],
        //             ];
        //         }, $items)
        //     ];
        // }

        // foreach ($this->jobsToUnload as $unload) {
        //     $items = array_values(array_filter($unload['opportunity_items'], function ($item) {
        //         return $item['item_id'] !== null && $item['accessory_mode'] === null;
        //     }));

        //     if (empty($items)) {
        //         continue;
        //     }

        //     $this->itemsToUnload = [
        //         ...$this->itemsToUnload,
        //         ...array_map(function ($itemToUnload) use ($unload) {
        //             return [
        //                 'item_id' => $itemToUnload['item_id'],
        //                 'name' => $itemToUnload['name'],
        //                 'quantity' => intval($itemToUnload['quantity']),
        //                 'job' => [
        //                     'subject' => $unload['subject'],
        //                     'unload_ends_at' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $unload['unload_ends_at'], 'UTC')->setTimezone(config('app.timezone')),
        //                 ],
        //             ];
        //         }, $items)
        //     ];
        // }

        $this->itemsToLoad = [
            [
                "item_id" => 830,
                "name" => "EXE Rise 500kg Chain Hoist D8 Plus Double Break 4m/min 20m",
                "quantity" => 7,
                "job" => [
                    "subject" => "Job A",
                    "load_starts_at" => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', '2024-04-24T23:00:00.000Z', 'UTC')->setTimezone(config('app.timezone')),
                ],
            ],
            [
                "item_id" => 846,
                "name" => "Chain Motor Controller (8 way)",
                "quantity" => 1,
                "job" => [
                    "subject" => "Job B",
                    "load_starts_at" => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', '2024-04-24T23:00:00.000Z', 'UTC')->setTimezone(config('app.timezone')),
                ],
            ],
            [
                "item_id" => 830,
                "name" => "EXE Rise 500kg Chain Hoist D8 Plus Double Break 4m/min 20m",
                "quantity" => 4,
                "job" => [
                    "subject" => "Job C",
                    "load_starts_at" => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', '2024-04-24T23:00:00.000Z', 'UTC')->setTimezone(config('app.timezone')),
                ],
            ],
            [
                "item_id" => 2080,
                "name" => "MPH Pre-rig 3.0m Touring Truss Black c/w Dolley v3",
                "quantity" => 8,
                "job" => [
                    "subject" => "Job D",
                    "load_starts_at" => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', '2024-04-24T23:00:00.000Z', 'UTC')->setTimezone(config('app.timezone')),
                ],
            ],
            [
                "item_id" => 830,
                "name" => "EXE Rise 500kg Chain Hoist D8 Plus Double Break 4m/min 20m",
                "quantity" => 7,
                "job" => [
                    "subject" => "Job E",
                    "load_starts_at" => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', '2024-04-24T23:00:00.000Z', 'UTC')->setTimezone(config('app.timezone')),
                ],
            ],
            [
                "item_id" => 1535,
                "name" => "FireFly Festoon 20m - Warm White",
                "quantity" => 6,
                "job" => [
                    "subject" => "Job F",
                    "load_starts_at" => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', '2024-04-24T23:00:00.000Z', 'UTC')->setTimezone(config('app.timezone')),
                ],
            ],
        ];

        $this->itemsToUnload = [
            [
                "item_id" => 830,
                "name" => "EXE Rise 500kg Chain Hoist D8 Plus Double Break 4m/min 20m",
                "quantity" => 30,
                "job" => [
                    "subject" => "Job G",
                    "unload_ends_at" => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', '2024-04-24T21:00:00.000Z', 'UTC')->setTimezone(config('app.timezone')),
                ],
            ],
            [
                "item_id" => 846,
                "name" => "Chain Motor Controller (8 way)",
                "quantity" => 9,
                "job" => [
                    "subject" => "Job H",
                    "unload_ends_at" => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', '2024-04-24T21:00:00.000Z', 'UTC')->setTimezone(config('app.timezone')),
                ],
            ],
            [
                "item_id" => 830,
                "name" => "EXE Rise 500kg Chain Hoist D8 Plus Double Break 4m/min 20m",
                "quantity" => 4,
                "job" => [
                    "subject" => "Job I",
                    "unload_ends_at" => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', '2024-04-24T21:00:00.000Z', 'UTC')->setTimezone(config('app.timezone')),
                ],
            ],
        ];
    }

    private function setQET(): void
    {
        foreach ($this->itemsToLoad as &$load) {
            foreach ($this->itemsToUnload as &$unload) {
                if ($unload['item_id'] === $load['item_id']) {
                    $unload_ends_at = $unload['job']['unload_ends_at'];
                    $load_starts_at = $load['job']['load_starts_at'];

                    if ($load_starts_at > $unload_ends_at && $load['quantity'] > 0 && $unload['quantity'] > 0) {
                        $transfer = $load['quantity'] - $unload['quantity'];
                        $count = 0;

                        if ($transfer > 0) {
                            $count = $unload['quantity'];
                            $unload['quantity'] = 0;
                            $load['quantity'] = $transfer;
                        } else if ($transfer === 0) {
                            $count = $unload['quantity'];
                            $unload['quantity'] = 0;
                            $load['quantity'] = 0;
                        } else if ($transfer < 0) {
                            $count = $load['quantity'];
                            $unload['quantity'] = abs($transfer);
                            $load['quantity'] = 0;
                        }

                        $this->qet[] = [
                            'id' => uniqid(mt_rand(), true),
                            'unload_job' => [
                                'subject' => $unload['job']['subject'],
                                'date' => $unload_ends_at->format('Y-m-d H:i:s'),
                            ],
                            'load_job' => [
                                'subject' => $load['job']['subject'],
                                'date' => $load_starts_at->format('Y-m-d H:i:s'),
                            ],
                            'item' => $load['name'],
                            'count' => $count,
                        ];
                    }
                }
            }
        }
    }
}
