<?php

namespace App\Http\Controllers;

use App\Enums\JobStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OpportunityController extends Controller
{
    public function search(Request $request)
    {
        $request_collection = $request->collect();
        $term = $request_collection->get('term');
        $params = $request_collection->forget('term');

        $url = 'opportunities';

        if ($params->isNotEmpty()) {
            $params = preg_replace('/\[\d+\]/', '[]', str_replace('?', $term, urldecode(http_build_query($params->toArray()))));
            $url = "{$url}?{$params}";
        }

        $response = Http::current()->get($url);

        ['opportunities' => $opportunities] = $response->json();

        if (empty($opportunities)) {
            return [];
        };

        return array_map(function ($opportunity) use ($request_collection) {
            $subject = $request_collection->dot()->has('q.number_cont')
                ? '🛠' . ' ' . $opportunity['subject'] . ' ' . $opportunity['number']
                : '🛠' . ' ' . $opportunity['subject'];

            return [
                'id' => $opportunity['id'],
                'text' => $subject,
                'technical_supervisor_id' => $opportunity['custom_fields']['mph_technical_supervisor'],
            ];
        }, $opportunities);
    }

    public function show(int $id)
    {
        $response = Http::current()->get("opportunities/{$id}");
        ['opportunity' => $opportunity] = $response->json();

        return $opportunity;
    }
}
