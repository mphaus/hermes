<x-mail::message>
[This is an automated message]

A new item was submitted to Quarantine via Hermes on {{ now()->format('d-M-Y') }} by {{ $user->fullname }};

<x-mail::panel>
**Opportunity / Project:** {{ $quarantine['custom_fields']['project_or_opportunity'] }}

**Serial number:** {{ $quarantine['reference'] }}

**Product:** {{ $quarantine['item']['name'] }}

**Fault classification:** {{ $fault_classification }}
</x-mail::panel>                                  

See <a href="https://mphaustralia.current-rms.com/quarantines/{{ $quarantine['id'] }}" target="_blank" rel="nofollow">item's Quarantine page in CurrentRMS</a>.

This item now needs to be checked for how its' Quarantining affects future Jobs. See <a href="https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/Shared%20Documents/Process/01%20In%20development/Process_%20Repairs%20Quarantine%20intake.docx?d=wc450b4cdc2e84c758363390091b56915&csf=1&web=1&e=hAKMaz&nav=eyJoIjoiODI5NzM5MzY2In0" target="_blank" rel="nofollow">"Determine if equipment is needed on upcoming Jobs" section of the Quarantine Intake process</a> for details on how to do this.

Then, work on the item needs to be prioritised accordingly on the <a href="https://planner.cloud.microsoft/webui/plan/w2pc0IJEcEugQYvOV1sGPMgAGyQQ?tid=6ab23282-f366-406e-aeed-bee8ded2a924" target="_blank" rel="nofollow">Quarantine Planner board</a>.

End.
</x-mail::message>
