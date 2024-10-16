<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProjectController extends Controller
{
    public function search(Request $request)
    {
        $response = Http::current()
            ->withQueryParameters([
                'per_page' => 20,
                'filtermode' => 'active',
                'q[name_cont]' => $request->get('q'),
            ])
            ->get('projects');

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
