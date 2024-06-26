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

    public function get(string $date): array|null|\GuzzleHttp\Exception\ClientException
    {
        $this->date = $date;
        $responses = $this->getJobs();

        if ($responses instanceof \GuzzleHttp\Exception\ClientException) {
            return $responses;
        }

        $this->setJobs($responses);

        if (empty($this->jobsToLoad) || empty($this->jobsToUnload)) {
            return null;
        }

        $this->setItems();

        if (empty($this->itemsToLoad) || empty($this->itemsToUnload)) {
            return null;
        }

        $this->setQET();

        return $this->qet;
    }

    private function getJobs(): array|\GuzzleHttp\Exception\ClientException
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
            return $th;
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
        foreach ($this->jobsToLoad as $load) {
            $items = array_values(array_filter($load['opportunity_items'], function ($item) {
                return $item['item_id'] !== null && $item['has_shortage'] === true && $item['accessory_mode'] === null;
            }));

            if (empty($items)) {
                continue;
            }

            $this->itemsToLoad = [
                ...$this->itemsToLoad,
                [
                    'job' => [
                        'id' => $load['id'],
                        'subject' => $load['subject'],
                        'load_starts_at' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $load['load_starts_at'], 'UTC')->setTimezone(config('app.timezone'))
                    ],
                    'items' => array_map(function ($itemToLoad) use ($load) {
                        return [
                            'item_id' => $itemToLoad['item_id'],
                            'name' => $itemToLoad['name'],
                            'quantity' => intval($itemToLoad['quantity']),
                        ];
                    }, $items)
                ]
            ];
        }

        foreach ($this->jobsToUnload as $unload) {
            $items = array_values(array_filter($unload['opportunity_items'], function ($item) {
                return $item['item_id'] !== null && $item['accessory_mode'] === null;
            }));

            if (empty($items)) {
                continue;
            }

            $this->itemsToUnload = [
                ...$this->itemsToUnload,
                ...array_map(function ($itemToUnload) use ($unload) {
                    return [
                        'item_id' => $itemToUnload['item_id'],
                        'name' => $itemToUnload['name'],
                        'quantity' => intval($itemToUnload['quantity']),
                        'job' => [
                            'id' => $unload['id'],
                            'subject' => $unload['subject'],
                            'unload_ends_at' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $unload['unload_ends_at'], 'UTC')->setTimezone(config('app.timezone')),
                        ],
                    ];
                }, $items)
            ];
        }
    }

    private function setQET(): void
    {
        foreach ($this->itemsToLoad as $load) {
            $items = [];

            foreach ($load['items'] as &$item) {
                foreach ($this->itemsToUnload as &$unload) {
                    if ($unload['item_id'] === $item['item_id']) {
                        $unload_ends_at = $unload['job']['unload_ends_at'];
                        $load_starts_at = $load['job']['load_starts_at'];

                        if ($load_starts_at > $unload_ends_at && $item['quantity'] > 0 && $unload['quantity'] > 0) {
                            $transfer = $item['quantity'] - $unload['quantity'];
                            $count = 0;

                            if ($transfer > 0) {
                                $count = $unload['quantity'];
                                $unload['quantity'] = 0;
                                $item['quantity'] = $transfer;
                            } else if ($transfer === 0) {
                                $count = $unload['quantity'];
                                $unload['quantity'] = 0;
                                $item['quantity'] = 0;
                            } else if ($transfer < 0) {
                                $count = $item['quantity'];
                                $unload['quantity'] = abs($transfer);
                                $item['quantity'] = 0;
                            }

                            $existingItems = array_filter($items, function ($existingItem) use ($item, $unload) {
                                return $existingItem['item_id'] === $item['item_id'] && $existingItem['unload_job_id'] === $unload['job']['id'];
                            });

                            $key = array_key_first($existingItems);

                            if ($key !== null) {
                                $currentItem = $items[$key];
                                $newCount = $count + $currentItem['count'];

                                $items[$key] = [
                                    ...$currentItem,
                                    'count' => $newCount,
                                ];

                                continue;
                            }

                            $items[] = [
                                'id' => uniqid(mt_rand(), true),
                                'item_id' => $item['item_id'],
                                'unload_job_id' => $unload['job']['id'],
                                'unload_job' => [
                                    'subject' => $unload['job']['subject'],
                                    'date' => $unload_ends_at->format('Y-m-d H:i:s'),
                                ],
                                'name' => $item['name'],
                                'count' => $count,
                            ];
                        }
                    }
                }
            }

            if (empty($items)) {
                continue;
            }

            $this->qet[] = [
                'job' => [
                    ...$load['job'],
                    'date' => $load_starts_at->format('Y-m-d H:i:s'),
                ],
                'items' => [...$items],
            ];
        }
    }
}
