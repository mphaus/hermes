@use('Illuminate\Support\Js')

<div class="space-y-1" x-data="QuarantineIntakeObject({{ Js::from($technicalSupervisors) }})">
    <x-input-label>{{ __('Opportunity or Project') }}</x-input-label>
    <select class="block w-full" x-ref="object"></select>
</div>
