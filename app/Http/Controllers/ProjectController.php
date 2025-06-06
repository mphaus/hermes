<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProjectController extends Controller
{
    public function search(Request $request)
    {
        $request_collection = $request->collect();
        $term = $request_collection->get('term');
        $params = $request_collection->forget('term');

        $url = 'projects';

        if ($params->isNotEmpty()) {
            $params = preg_replace('/\[\d+\]/', '[]', str_replace('?', $term, urldecode(http_build_query($params->toArray()))));
            $url = "{$url}?{$params}";
        }

        $response = Http::current()->get($url);

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
