<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuarantineRequest;

class StoreQuarantineController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreQuarantineRequest $request)
    {
        $result = $request->store();

        ['error' => $error, 'data' => $data] = $result;

        if ($error) {
            return to_route(route: 'quarantine.create', status: 303)->withErrors([
                'quarantine_create_error_message' => __('Fail! ❌ The Quarantine Item was not added to CurrentRMS because <span class="font-semibold">:error</span>. This item still needs to be added. It\'s fine to try again, but the same error may return.</p><p>See <a href=":url" target="_blank" rel="nofollow" title="Dealing with errors when adding items to Quarantine via Hermes section" class="font-semibold">Dealing with errors when adding items to Quarantine via Hermes section</a> in the Quarantine Intake Process for instructions on what to do next.</p>', [
                    'error' => $error,
                    'url' => 'https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/Shared%20Documents/Process/01%20In%20development/Process_%20Repairs%20Quarantine%20intake.docx?d=wc450b4cdc2e84c758363390091b56915&csf=1&web=1&e=sFkHAk&nav=eyJoIjoiMzg4NTM5MDQifQ'
                ])
            ]);
        }

        return to_route('quarantine.create');
    }
}
