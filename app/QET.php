<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Support\Carbon;

class QET
{
    public function get(string $date)
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $date);
        $endDate = Carbon::createFromFormat('Y-m-d', $date);

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
        } catch (\Throwable $th) {
            // RETURN ERROR
        }

        $jobsToLoad = [];
        $jobsToUnload = [];

        foreach ($responses as $key => $response) {
            $res = json_decode($response->getBody(), true);

            switch ($key) {
                case 'load':
                    $jobsToLoad = $res['opportunities'];
                    break;
                case 'unload':
                    $jobsToUnload = $res['opportunities'];
                    break;
                default:
                    break;
            }
        }

        if (empty($jobsToLoad) || empty($jobsToUnload)) {
            // RETURN EMPTY RESPONSE
        }

        $qet = [];

        foreach ($jobsToLoad as $jobToLoad) {
            foreach ($jobsToUnload as $jobToUnload) {
            }
        }

        return $qet;
    }
}
