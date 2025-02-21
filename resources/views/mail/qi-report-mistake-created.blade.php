<x-mail::message>
[This is an automated message]

A new item was submitted to Quarantine via Hermes on {{ $quarantine['submitted'] }} by {{ $user->fullname }} that needs correction;

<x-mail::panel>
**Intake location:** {{ $quarantine['intake_location'] }}

**CurrentRMS Quarantine ID:** {{ $quarantine['quarantine_id'] }}

**Job:** {{ $quarantine['job'] }}

**Product:** {{ $quarantine['product'] }}

**Serial:** {{ $quarantine['serial'] }}

**Ready for repairs:** {{ $quarantine['ready_for_repairs'] }}

**Primary fault classification:** {{ $quarantine['primary_fault_classification'] }}

**Fault description**: {{ $quarantine['fault_description'] }}
</x-mail::panel>

Corrections that need to be made:

<x-mail::panel>
{{ $quarantine['message'] }}
</x-mail::panel>
</x-mail::message>
