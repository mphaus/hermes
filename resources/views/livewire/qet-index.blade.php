<x-slot name="title">{{ __('QET') }}</x-slot>
<x-slot name="heading">{{ __('QET') }}</x-slot>
<div class="flow" x-data="Qet">
    @if ($qet['error'])
        <x-generic-error :message="$qet['error']" />
    @else
        <section class="flex items-end gap-2">
            <div class="flex-1 space-y-1 max-w-64">
                <x-input-label value="{{ __('Date') }}" class="!text-xs" />
                <x-input
                    type="text"
                    placeholder="{{ __('Select a date') }}"
                    class="block w-full"
                    readonly
                    x-ref="date"
                />
            </div>
            <x-button variant="primary" x-on:click="clearDate">{{ __('Clear') }}</x-button>
        </section>
        <div class="mt-8" wire:loading.block wire:target="setDate">
            @include('qet-skeleton')
        </div>
        @if ($qet['groups']->isNotEmpty())
            <section class="mt-8 space-y-8 flow" wire:loading.class="hidden" wire:target="setDate" wire:poll.300s>
                <div class="flex flex-col gap-2 text-sm sm:flex-row sm:items-center sm:justify-between">
                    <p>{{ __('Quick Equipment Transfers for :date +24 hours', ['date' => now()->parse($date)->format('l d M Y')]) }}</p>
                    <p>{{ __('Last update: :time', ['time' => now()->format('Hi')]) }}</p>
                </div>
                @foreach ($qet['groups'] as $group)
                    <x-qet-group :group="$group" wire:key="{{ $group['job']['id'] }}" />
                @endforeach
            </section>
        @else
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg" wire:loading.class="hidden">
                <div class="p-6 text-gray-900">
                    {{ __('There is no QET to display. Please, select a date') }}
                </div>
            </div>
        @endif
    @endif
</div>
