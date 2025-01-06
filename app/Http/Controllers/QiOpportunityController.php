<?php

namespace App\Http\Controllers;

use App\Enums\JobStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QiOpportunityController extends Controller
{
    public function search(Request $request)
    {
        $response = Http::current()
            ->withQueryParameters([
                'per_page' => 25,
                'q[status_eq]' => JobStatus::Reserved->value,
                'q[subject_cont]' => $request->get('q'),
            ])
            ->get('opportunities');

        ['opportunities' => $opportunities] = $response->json();

        if (empty($opportunities)) {
            return [];
        }

        return array_map(fn($opportunity) => [
            'id' => '🛠' . ' ' . $opportunity['subject'],
            'text' => '🛠' . ' ' . $opportunity['subject'],
            'technical_supervisor_id' => $opportunity['custom_fields']['mph_technical_supervisor'],
        ], $opportunities);
    }
}
