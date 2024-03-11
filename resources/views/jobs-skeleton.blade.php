<div>
    <x-slot name="title">{{ __('Jobs list') }}</x-slot>
    <x-slot name="heading">
        <span>{{ __('Active Jobs') }}</span>
        <span class="block mt-2 text-sm font-normal">{{ __('Jobs in CurrentRMS with the "State" of "Order" and "Open".') }}</span>
    </x-slot>
    <div class="space-y-4">
        <div class="hidden lg:block">
            <div class="px-6 grid items-center grid-cols-[28rem_1fr_1fr] xl:grid-cols-[45rem_1fr_1fr] text-sm gap-2 font-semibold animate-pulse">
                <div class="h-5 bg-gray-200 rounded-lg"></div>
                <div class="h-5 bg-gray-200 rounded-lg"></div>
                <div class="h-5 bg-gray-200 rounded-lg"></div>
            </div>
        </div>
        @for ($i = 0; $i < 25; $i++)
            <x-card class="relative">
                <div class="flex flex-col gap-2 lg:grid lg:grid-cols-[28rem_1fr_1fr] lg:items-center xl:grid-cols-[45rem_1fr_1fr] animate-pulse">
                    <div class="h-6 bg-gray-200 rounded-lg"></div>
                    <div class="h-5 bg-gray-200 rounded-lg"></div>
                    <div class="h-5 bg-gray-200 rounded-lg"></div>
                </div>
            </x-card>
        @endfor
    </div>
</div>
