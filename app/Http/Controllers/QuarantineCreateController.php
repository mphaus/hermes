<?php

namespace App\Http\Controllers;

use App\Services\CurrentRMSApiService;
use App\Traits\WithQuarantineFaultClassification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuarantineCreateController extends Controller
{
    use WithQuarantineFaultClassification;

    private const DATA = [
        'error' => '',
        'data' => [],
    ];

    public function __construct(
        protected CurrentRMSApiService $currentrms
    ) {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('QuarantineCreate', [
            'title' => 'Quarantine Intake',
            'description' => 'Refer to the <a href="https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/Shared%20Documents/Process/01%20In%20development/Process_%20Repairs%20Quarantine%20intake.docx?d=wc450b4cdc2e84c758363390091b56915&csf=1&web=1&e=BkqZrw&nav=eyJoIjoiMjAwNzMzMjA1NyJ9" target="_blank" rel="nofollow" title="Add Product to Quarantine via Hermes section">Add Product to Quarantine via Hermes section</a> of the Quarantine Intake Process for detailed instructions. Check out what\'s already in <a href="https://mphaustralia.current-rms.com/quarantines" target="_blank" rel="nofollow">Quarantine in CurrentRMS</a> (this is available to full-time MPH staff, and casuals in the warehouse via the computer at the Quarantine Intake desk). ',
            'technical_supervisors_data' => Inertia::defer(fn() => $this->technicalSupervisorsData())->once(),
            'members_data' => Inertia::defer(fn() => $this->membersData())->once(),
            'min_date' => now()->format('Y-m-d'),
            'max_date' => now()->addMonths(1)->endOfMonth()->format('Y-m-d'),
            'fault_classifications' => $this->getFaultClassifications(),
        ]);
    }

    private function technicalSupervisorsData()
    {
        $list_id = config('app.mph.technical_supervisor_list_id');
        $result = $this->currentrms->fetch("list_names/{$list_id}");

        if ($result['fail']) {
            return [
                ...self::DATA,
                'error' => 'An unexpected error occurred while fetching the Technical Supervisors list. Please refresh the page and try again. ' . json_encode($result['fail']['data']),
            ];
        }

        return [
            ...self::DATA,
            'data' => $result['data']['list_name']['list_values'] ?? [],
        ];
    }

    private function membersData()
    {
        $result = $this->currentrms->fetch('members', [
            'per_page' => 100,
            'filtermode' => 'user',
            'q' => [
                'active_eq' => true,
            ],
        ]);

        if ($result['fail']) {
            return [
                ...self::DATA,
                'error' => 'An unexpected error occurred while fetching the Members list. Please refresh the page and try again. ' . json_encode($result['fail']['data']),
            ];
        }

        return [
            ...self::DATA,
            'data' => $result['data']['members'] ?? [],
        ];
    }
}
