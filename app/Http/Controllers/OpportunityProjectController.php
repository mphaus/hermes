<?php

namespace App\Http\Controllers;

use App\Enums\JobStatus;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OpportunityProjectController extends Controller
{
    public function search(Request $request)
    {
        $projects_query_params = preg_replace('/\[\d+\]/', '[]',  urldecode(http_build_query([
            'per_page' => 20,
            'filtermode' => 'active',
            'q[name_cont]' => $request->get('q'),
            'q[s]' => ['starts_at+desc'],
        ])));

        $opportunities_query_params = preg_replace('/\[\d+\]/', '[]', urldecode(http_build_query([
            'per_page' => 25,
            // 'filtermode' => 'quotations',
            'q[status_eq]' => JobStatus::Reserved->value,
            'q[subject_cont]' => $request->get('q'),
        ])));

        $headers = [
            'X-AUTH-TOKEN' => config('app.current_rms.auth_token'),
            'X-SUBDOMAIN' => config('app.current_rms.subdomain'),
        ];

        $host = config('app.current_rms.host');

        $responses = Http::pool(function (Pool $pool) use ($projects_query_params, $opportunities_query_params, $headers, $host) {
            return [
                $pool->as('projects')->withHeaders($headers)->get("{$host}projects?{$projects_query_params}"),
                $pool->as('opportunities')->withHeaders($headers)->get("{$host}opportunities?{$opportunities_query_params}"),
            ];
        });

        ['projects' => $projects] = $responses['projects']->json();
        ['opportunities' => $opportunities] = $responses['opportunities']->json();

        if (empty($projects) && empty($opportunities)) {
            return [];
        }

        if ($projects) {
            return array_map(fn($project) => [
                'id' => '⚓' . ' ' . $project['name'],
                'text' => '⚓' . ' ' . $project['name'],
                'technical_supervisor_id' => $project['custom_fields']['mph_technical_supervisor'],
            ], $projects);
        }

        if ($opportunities) {
            return array_map(fn($opportunity) => [
                'id' => '🛠' . ' ' . $opportunity['subject'],
                'text' => '🛠' . ' ' . $opportunity['subject'],
                'technical_supervisor_id' => $opportunity['custom_fields']['mph_technical_supervisor'],
            ], $opportunities);
        }
    }
}
