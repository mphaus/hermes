<div>
    <x-slot name="title">{{ __('Loading...') }}</x-slot>
    <x-slot name="heading">{{ __('Loading...') }}</x-slot>
    <x-card>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4 md:gap-6 animate-pulse">
            <div class="h-6 col-span-2 bg-gray-200 rounded-lg md:col-span-4"></div>
            <div class="flex flex-col gap-1">
                <div class="h-5 bg-gray-200 rounded-lg"></div>
                <div class="h-5 bg-gray-200 rounded-lg"></div>
            </div>
            <div class="flex flex-col gap-1">
                <div class="h-5 bg-gray-200 rounded-lg"></div>
                <div class="h-5 bg-gray-200 rounded-lg"></div>
            </div>
            <div class="flex flex-col gap-1">
                <div class="h-5 bg-gray-200 rounded-lg"></div>
                <div class="h-5 bg-gray-200 rounded-lg"></div>
            </div>
            <div class="flex flex-col gap-1">
                <div class="h-5 bg-gray-200 rounded-lg"></div>
                <div class="h-5 bg-gray-200 rounded-lg"></div>
            </div>
        </div>
    </x-card>
</div>
