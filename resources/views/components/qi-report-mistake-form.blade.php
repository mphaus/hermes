<x-form 
    action="{{ route('quarantine-intake-report-mistake.store') }}"
    method="POST" 
    class="space-y-1"
    x-data="QiReportMistakeForm"
    x-on:submit.prevent="send"
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
</x-form>
