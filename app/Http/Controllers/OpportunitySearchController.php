<?php

namespace App\Http\Controllers;

use App\Services\CurrentRMSApiService;
use Illuminate\Http\Request;

class OpportunitySearchController extends Controller
{
    public function __construct(
        protected CurrentRMSApiService $currentrms
    ) {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request_collection = $request->collect();
        $term = $request_collection->get('term');
        $params = $request_collection->forget('term');
        $uri = 'opportunities';

        if ($params->isNotEmpty()) {
            $params = preg_replace('/\[\d+\]/', '[]', str_replace('?', $term, urldecode(http_build_query($params->toArray()))));
            $uri = "{$uri}?{$params}";
        }

        $result = $this->currentrms->fetch($uri);

        if ($result['fail']) {
            return response()->json([]);
        }

        ['opportunities' => $opportunities] = $result['data'];

        if (empty($opportunities)) {
            return response()->json([]);
        };

        return response()->json(array_map(function ($opportunity) use ($request_collection) {
            $subject = $request_collection->dot()->has('q.number_cont')
                ? $opportunity['subject'] . ' ' . $opportunity['number']
                : $opportunity['subject'];

            return [
                'id' => $opportunity['id'],
                'subject' => $subject,
                'technical_supervisor_id' => $opportunity['custom_fields']['mph_technical_supervisor'],
            ];
        }, $opportunities));
    }
}
