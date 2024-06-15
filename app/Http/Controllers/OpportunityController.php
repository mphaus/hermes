<?php

namespace App\Http\Controllers;

use App\Enums\JobStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OpportunityController extends Controller
{
    public function search(Request $request)
    {
        $response = Http::current()
            ->withQueryParameters([
                'per_page' => 25,
                'filtermode' => 'quotations',
                'q[status_eq]' => JobStatus::Reserved->value,
                'q[id_not_eq]' => config('app.mph.test_opportunity_id'),
                'q[subject_cont]' => $request->get('q'),
            ])
            ->get('opportunities');

        ['opportunities' => $opportunities] = $response->json();

        if (empty($opportunities)) {
            return [];
        }

        return array_map(fn ($opportunity) => [
            'id' => $opportunity['id'],
            'text' => $opportunity['subject'],
        ], $opportunities);
    }

    public function show(int $id)
    {
        $response = Http::current()->get("opportunities/{$id}");
        ['opportunity' => $opportunity] = $response->json();

        return $opportunity;
    }
}
