<x-slot name="title">{{ __('QET') }}</x-slot>
<x-slot name="heading">{{ __('QET') }}</x-slot>
<div class="flow">
    <div class="space-y-1 max-w-96">
        <x-input-label value="{{ __('Date') }}" class="!text-xs" />
        <x-input type="text" placeholder="{{ __('Select a date') }}" class="block w-full" />
    </div>
    <section class="mt-8 flow">
        <div class="flex flex-col gap-2 text-sm sm:flex-row sm:items-center sm:justify-between">
            <p>{{ __('Quick Equipment Transfers for Monday 23 Jul 2024 +24 hours') }}</p>
            <p>{{ __('Last update: 1342') }}</p>
        </div>
        <div class="hidden mt-8 lg:block">
            <div class="grid grid-cols-8 px-6 text-sm font-semibold">
                <p class="col-span-2">{{ __('Coming off Job') }}</p>
                <p class="col-span-2">{{ __('Going to Job') }}</p>
                <p class="col-span-2">{{ __('Item') }}</p>
                <p>{{ __('Count') }}</p>
                <p>{{ __('Time remaining') }}</p>
            </div>
        </div>
        <x-card>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-8 lg:gap-2">
                <div class="flex flex-col gap-1 text-sm lg:col-span-2">
                    <p class="font-semibold lg:hidden">{{ __('Coming off Job') }}</p>
                    <p class="flex flex-col gap-1">
                        <span>Lorem, ipsum dolor.</span>
                        <span class="flex items-center text-xs">
                            (<x-icon-arrow-down class="w-3 h-3" />
                            <span class="block ml-1">at 1000 Tue Jul 23</span>)
                        </span>
                    </p>
                </div>
                <div class="flex flex-col gap-1 text-sm lg:col-span-2">
                    <p class="font-semibold lg:hidden">{{ __('Going to Job') }}</p>
                    <p class="flex flex-col gap-1">
                        <span>Lorem ipsum dolor sit amet.</span>
                        <span class="flex items-center text-xs">
                            (<x-icon-arrow-up class="w-3 h-3" />
                            <span class="block ml-1">at 1400 Tue Jul 24</span>)
                        </span>
                    </p>
                </div>
                <div class="flex flex-col gap-1 text-sm md:col-span-2">
                    <p class="font-semibold lg:hidden">{{ __('Item') }}</p>
                    <p>Lorem ipsum dolor sit amet consectetur.</p>
                </div>
                <div class="flex flex-col gap-1 text-sm">
                    <p class="font-semibold lg:hidden">{{ __('Count') }}</p>
                    <p>30</p>
                </div>
                <div class="flex flex-col gap-1 text-sm">
                    <p class="font-semibold lg:hidden">{{ __('Time remaining') }}</p>
                    <p>2h</p>
                </div>
            </div>
        </x-card>
    </section>
</div>
