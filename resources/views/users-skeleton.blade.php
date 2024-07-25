<div>
    <x-slot name="title">{{ __('Users') }}</x-slot>
    <x-slot name="heading">
        <span>{{ __('Users') }}</span>
        <span class="block mt-2 text-sm font-normal">{{ __('New users can be created and exiting users edited (or deleted) here.') }}</span>
    </x-slot>
    <div class="space-y-4">
        <div class="hidden lg:block">
            <div class="grid items-center grid-cols-10 gap-2 px-6 animate-pulse">
                <div class="h-5 col-span-2 bg-gray-200 rounded-lg"></div>
                <div class="h-5 col-span-2 bg-gray-200 rounded-lg"></div>
                <div class="h-5 col-span-3 bg-gray-200 rounded-lg"></div>
                <div class="h-5 bg-gray-200 rounded-lg"></div>
                <div class="h-5 bg-gray-200 rounded-lg"></div>
                <div class="h-5 bg-gray-200 rounded-lg"></div>
            </div>
        </div>
        @for ($i = 0; $i < 3; $i++)
            <x-card>
                <div class="grid gap-4 lg:grid-cols-10 animate-pulse">
                    <div class="h-5 bg-gray-200 rounded-lg lg:col-span-2"></div>
                    <div class="h-5 bg-gray-200 rounded-lg lg:col-span-2"></div>
                    <div class="h-5 bg-gray-200 rounded-lg lg:col-span-3"></div>
                    <div class="h-5 bg-gray-200 rounded-lg"></div>
                    <div class="h-5 bg-gray-200 rounded-lg"></div>
                    <div class="h-5 bg-gray-200 rounded-lg"></div>
                </div>
            </x-card>
        @endfor
    </div>
</div>
