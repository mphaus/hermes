<x-mail::message>
[This is an automated message]

A new item was submitted to Quarantine via Hermes on {{ now()->format('d-M-Y') }} by {{ $user->fullname }};

<x-mail::panel>
**Opportunity:** {{ $quarantine['custom_fields']['opportunity'] }}

**Serial number:** {{ $quarantine['reference'] }}

**Product:** {{ $quarantine['item']['name'] }}

**Fault classification:** {{ $fault_classification }}

**Fault description:** {{ $description }}
</x-mail::panel>                                  

See <a href="https://mphaustralia.current-rms.com/quarantines/{{ $quarantine['id'] }}" target="_blank" rel="nofollow">item's Quarantine page in CurrentRMS</a>.

This item now needs to be checked for how its' Quarantining affects future Jobs. See <a href="https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/Shared%20Documents/Process/Process_%20DWM%20Service,%20Repairs,%20Maintenance%20and%20Manufacturing%20Manager.docx?d=w95728782b244437aa958768a9078cfad&csf=1&web=1&e=K1bja5&nav=eyJoIjoiNTQyOTM4MTk5In0" target="_blank" rel="nofollow">"Determine if equipment is needed on upcoming Jobs" section of the DWM SRRM Manager process</a> for details on how to do this.

Then, work on the item needs to be prioritised accordingly on the <a href="https://planner.cloud.microsoft/webui/plan/w2pc0IJEcEugQYvOV1sGPMgAGyQQ?tid=6ab23282-f366-406e-aeed-bee8ded2a924" target="_blank" rel="nofollow">Quarantine Planner board</a>.

End.
</x-mail::message>
