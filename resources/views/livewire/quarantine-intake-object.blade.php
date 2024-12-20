@use('Illuminate\Support\Js')

<div 
    class="flow" 
    x-data="QuarantineIntakeObject({{ Js::from($technicalSupervisors) }})"
    x-on:hermes:quarantine-intake-cleared.window="clear"
>
    <div class="flow">
        <label class="block font-semibold">{{ __('Opportunity or Project') }}</label>
        <div class="flex items-start gap-1 mt-2">
            <x-icon-info class="flex-shrink-0 w-4 h-4 text-blue-500" />
            <p class="text-xs">{{ __('If there is an Opportunity and a Project with the same name, only the Project will be selectable. This ensures all quarantined items are grouped by Project.') }}</p>
        </div>
        <select class="block w-full" x-ref="object"></select>
    </div>
    <div class="flow" x-cloak x-show="$wire.$parent.form.technical_supervisor">
        <label class="block font-semibold">{{ __('Technical Supervisor') }}</label>
        <div class="flex items-start gap-1 mt-2">
            <x-icon-info class="flex-shrink-0 w-4 h-4 text-blue-500" />
            <p class="text-xs">{{ __('The Technical Supervisor is specified in the Opportunity or Project and cannot be changed here.') }}</p>
        </div>
        <p x-text="technicalSupervisorName"></p>
    </div>
    <p class="text-sm text-red-600" x-cloak x-show="technicalSupervisorDoesNotExist">{{ __('This Project or Opportunity does not have an assigned Technical Supervisor. Please assign a Technical Supervisor in CurrentRMS and refresh this page to try again.') }}</p>
</div>
