<x-slot name="title">{{ __('Action Stream') }}</x-slot>
<x-slot name="heading">{{ __('Action Stream') }}</x-slot>
<div class="flow">
    @if ($this->actions['error'])
        <x-generic-error :message="$this->actions['error']" />
    @elseif ($this->actions['log']->isNotEmpty())
        <livewire:action-stream-filters :memberIds="$memberIds" :actionTypes="$actionTypes" :dateRange="$dateRange" />
        <section wire:loading.block>
            @include('action-stream-skeleton')
        </section>
        <section 
            class="mt-8 flow"
            wire:loading.class="hidden"
        >
            <div class="hidden xl:block">
                <div class="gap-2 px-6 text-sm font-semibold xl:grid grid-cols-[28rem_1fr_1fr_1fr_1fr_1fr]">
                    <p>{{ __('Job') }}</p>
                    <p>{{ __('User') }}</p>
                    <p>{{ __('Action') }}</p>
                    <p class="col-span-2">{{ __('Description') }}</p>
                    <p>{{ __('Date') }}</p>
                </div>
            </div>
            @foreach ($this->actions['log'] as $action)
                <x-action-stream-item :action="$action" wire:key="{{ $action['id'] }}" />
            @endforeach
            <div class="mt-8">{{ $this->actions['log']->links('pagination') }}</div>
        </section>
    @else
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __('There are no actions to display.') }}
                </div>
            </div>
        </div>
    @endif
</div>
