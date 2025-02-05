<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QiOpportunityController extends Controller
{
    public function search(Request $request)
    {
        $request_collection = $request->collect();
        $term = $request_collection->get('term');
        $params = $request_collection->forget('term');

        $url = 'opportunities';

        if ($params->isNotEmpty()) {
            $params = str_replace('?', $term, urldecode(http_build_query($params->toArray())));
            $url = "{$url}?{$params}";
        }

        $response = Http::current()->get($url);

        ['opportunities' => $opportunities] = $response->json();

        if (empty($opportunities)) {
            return [];
        };

        return array_map(fn($opportunity) => [
            'id' => '🛠' . ' ' . $opportunity['subject'],
            'text' => $request_collection->dot()->has('q.number_cont')
                ? '🛠' . ' ' . $opportunity['subject'] . ' ' . $opportunity['number']
                : '🛠' . ' ' . $opportunity['subject'],
            'technical_supervisor_id' => $opportunity['custom_fields']['mph_technical_supervisor'],
        ], $opportunities);
    }
}
