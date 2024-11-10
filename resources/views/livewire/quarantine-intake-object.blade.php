@use('Illuminate\Support\Js')

<div 
    class="flow" 
    x-data="QuarantineIntakeObject({{ Js::from($technicalSupervisors) }})"
    x-on:quarantine-intake-created.window="clear"
>
    <div class="space-y-1">
        <x-input-label>{{ __('Opportunity or Project') }}</x-input-label>
        <select class="block w-full" x-ref="object"></select>
    </div>
    <div class="space-y-1" x-cloak x-show="$wire.$parent.form.technical_supervisor">
        <x-input-label>{{ __('Technical Supervisor') }}</x-input-label>
        <p x-text="$wire.$parent.form.technical_supervisor"></p>
    </div>
    <p class="text-sm text-red-600" x-cloak x-show="technicalSupervisorDoesNotExist">{{ __('This Project or Opportunity does not have an assigned Technical Supervisor. Please assign a Technical Supervisor in CurrentRMS and refresh this page to try again.') }}</p>
</div>
