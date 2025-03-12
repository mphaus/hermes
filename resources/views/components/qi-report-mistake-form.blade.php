@props([
    'quarantine' => [],
])

<x-form 
    action="{{ route('quarantine-intake-report-mistake.store') }}"
    method="POST" 
    class="space-y-1"
    x-data="QiReportMistakeForm"
    x-on:submit.prevent="send"
>
    <input 
        type="hidden" 
        name="submitted" 
        value="{{ now()->parse($quarantine['created_at'])->setTimezone(config('app.timezone'))->format('d-M-Y \a\t Hi') }}"
        x-init="form[$el.name] = $el.value"
    >
    <input 
        type="hidden" 
        name="quarantine_id" 
        value="{{ $quarantine['id'] }}"
        x-init="form[$el.name] = Number($el.value)"
    >
    <input 
        type="hidden" 
        name="job" 
        value="{{ $quarantine['custom_fields']['opportunity'] }}"
        x-init="form[$el.name] = $el.value"
    >
    <input 
        type="hidden" 
        name="product" 
        value="{{ $quarantine['name'] }}"
        x-init="form[$el.name] = $el.value"
    >
    <input 
        type="hidden" 
        name="serial" 
        value="{{ $quarantine['reference'] }}"
        x-init="form[$el.name] = $el.value"
    >
    <input 
        type="hidden" 
        name="ready_for_repairs" 
        value="{{ now()->parse($quarantine['starts_at'])->setTimezone(config('app.timezone'))->format('d-M-Y \a\t Hi') }}"
        x-init="form[$el.name] = $el.value"
    >
    <input 
        type="hidden" 
        name="primary_fault_classification" 
        value="{{ $quarantine['primary_fault_classification'] }}"
        x-init="form[$el.name] = $el.value"
    >
    <input 
        type="hidden" 
        name="fault_description" 
        value="{{ $quarantine['description'] }}"
        x-init="form[$el.name] = $el.value"
    >
    <input 
        type="hidden" 
        name="intake_location" 
        value="{{ $quarantine['custom_fields']['intake_location'] }}"
        x-init="form[$el.name] = $el.value"
    >
    <div class="space-y-2">
        <x-textarea 
            rows="4" 
            x-model="form.message"
            x-on:input="remainingCharacters = 512 - form.message.length"
        ></x-textarea>
        <p 
            class="text-xs font-semibold"
            x-bind:class="{ 'text-red-500': remainingCharacters <= 0 }"
        >
            <span x-text="remainingCharacters"></span>
            {!! __('character<span x-show="remainingCharacters !== 1">s</span> left') !!}
        </p>
        <template hidden x-if="errors.message">
            <p class="text-sm text-red-600" x-text="errors.message"></p>
        </template>
    </div>
    <div class="flex justify-end">
        <x-button 
            variant="primary" 
            type="submit"
            x-bind:disabled="submitting"
        >
            <span x-show="!submitting">{{ __('Send') }}</span>
            <span x-cloak x-show="submitting">{{ __('Sending...') }}</span>
        </x-button>
    </div>
    <template hidden x-if="message">
        <div class="p-4 mt-4! text-white bg-green-500 rounded-md font-semibold" x-text="message"></div>
    </template>
</x-form>
