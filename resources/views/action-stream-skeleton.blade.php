<div>
    <x-slot name="title">{{ __('Action Stream') }}</x-slot>
    <x-slot name="heading">{{ __('Action Stream') }}</x-slot>
    <div class="space-y-4">
        <div class="hidden gap-2 px-6 text-sm font-semibold xl:grid grid-cols-[28rem_1fr_1fr_1fr_1fr_1fr] animate-pulse">
            <div class="h-5 bg-gray-200 rounded-lg"></div>
            <div class="h-5 bg-gray-200 rounded-lg"></div>
            <div class="h-5 bg-gray-200 rounded-lg"></div>
            <div class="h-5 col-span-2 bg-gray-200 rounded-lg"></div>
            <div class="h-5 bg-gray-200 rounded-lg"></div>
        </div>
        @for ($i = 0; $i < 3; $i++)
            <x-card>
                <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-[28rem_1fr_1fr_1fr_1fr_1fr] xl:items-center animate-pulse">
                    <div class="h-6 mb-2 bg-gray-200 rounded-lg sm:col-span-2 lg:col-span-4 xl:col-span-1 xl:mb-0"></div>
                    <div class="h-5 bg-gray-200 rounded-lg"></div>
                    <div class="h-5 bg-gray-200 rounded-lg"></div>
                    <div class="h-5 bg-gray-200 rounded-lg xl:col-span-2"></div>
                    <div class="h-5 bg-gray-200 rounded-lg"></div>
                </div>
            </x-card>    
        @endfor
    </div>
</div>
