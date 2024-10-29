<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProjectController extends Controller
{
    public function search(Request $request)
    {
        $query_params = preg_replace('/\[\d+\]/', '[]',  urldecode(http_build_query([
            'per_page' => 20,
            'filtermode' => 'active',
            'q[name_cont]' => $request->get('q'),
            'q[s]' => ['starts_at+desc'],
        ])));

        $response = Http::current()->get("projects?{$query_params}");

        ['projects' => $projects] = $response->json();

        if (empty($projects)) {
            return [];
        }

        return array_map(fn($project) => [
            'id' => $project['id'],
            'text' => $project['name'],
        ], $projects);
    }
}
