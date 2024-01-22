<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('csv', function () {
    $data = [];
    $header = null;
    if (($handle = fopen("./../storage/app/mph-csv-test.csv", "r")) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($header === null) {
                $header = $row;
                continue;
            }

            $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }

    $response = Http::withQueryParameters([
        'opportunity_item[item_id]' => $data[0]['id'],
        'opportunity_item[quantity]' => $data[0]['quantity'],
        'opportunity_item[opportunity_id]' => 3132,
        'opportunity_item[parent_opportunity_item_id]' => 82702,
    ])
        ->withHeaders([
            'X-AUTH-TOKEN' => config('app.current_rms.auth_token'),
            'X-SUBDOMAIN' => config('app.current_rms.subdomain'),
        ])
        ->post('https://api.current-rms.com/api/v1/opportunities/3132/opportunity_items');

    $response->throw();

    return $response;
});
