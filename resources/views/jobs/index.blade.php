<x-layout.app>
    <x-slot name="title">{{ __('Jobs list') }}</x-slot>
    <x-slot name="heading">{{ __('Active Jobs') }}</x-slot>
    @if ($opportunities->isNotEmpty())
        <div class="space-y-4">
            <div class="hidden mx-auto max-w-7xl sm:px-6 lg:px-8 lg:block">
                <div class="px-6 grid items-center grid-cols-[28rem_1fr_1fr_1fr] xl:grid-cols-[45rem_1fr_1fr_1fr] text-sm gap-2 text-gray-400">
                    <p>{{ __('Subject') }}</p>
                    <p>{{ __('Start date') }}</p>
                    <p>{{ __('End date') }}</p>
                    <p>{{ __('Revenue') }}</p>
                </div>
            </div>
            <x-jobs.list :opportunities="$opportunities" />
        </div>
    @else
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __('Currently, there are no active Jobs.') }}
                </div>
            </div>
        </div>
    @endif
</x-layout.app>
