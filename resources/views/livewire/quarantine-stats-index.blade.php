<x-slot name="title">{{ __('Quarantine Stats') }}</x-slot>
<x-slot name="heading">{{ __('Quarantine Stats') }}</x-slot>
<div>
    <x-card class="space-y-4">
        <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-4">
            <x-button type="button" variant="outline-primary">{{ __('Last week') }}</x-button>
            <x-button type="button" variant="outline-primary">{{ __('Last 30 days') }}</x-button>
            <x-button type="button" variant="outline-primary">{{ __('Last 90 days') }}</x-button>
            <x-input type="text" />
        </div>
        <div class="grid gap-2 sm:grid-cols-2">
            <div class="space-y-1">
                <x-input-label>{{ __('Products') }}</x-input-label>
                <x-select-product :multiple="true" />
            </div>
            <div class="space-y-1">
                <x-input-label>{{ __('Technical Supervisors') }}</x-input-label>
                <select name="" id="" class="w-full"></select>
            </div>
            <div class="space-y-1">
                <x-input-label>{{ __('Opportunities or Projects') }}</x-input-label>
                <select name="" id="" class="w-full"></select>
            </div>
            <div class="space-y-1">
                <x-input-label>{{ __('Fault root cause') }}</x-input-label>
                <select name="" id="" class="w-full"></select>
            </div>
        </div>
        <div class="flex flex-col items-end gap-4">
            <div class="flex items-start gap-2">
                <x-input-checkbox id="show_items_currently_in_quarantine" class="mt-0.5" />
                <x-input-label for="show_items_currently_in_quarantine" class="font-semibold cursor-pointer">{{ __('Show items currently in Quarantine') }}</x-input-label>
            </div>
            <x-button type="button" variant="primary">{{ __('Filter') }}</x-button>
        </div>
    </x-card>
    <section class="mt-8 flow">
        <div class="hidden xl:block">
            <div class="grid grid-cols-5 gap-2 px-6 text-sm font-semibold">
                <p>{{ __('Product') }}</p>
                <p class="col-span-2">{{ __('Opportunity / Project') }}</p>
                <p>{{ __('Technical Supervisor') }}</p>
                <p>{{ __('Repaired date') }}</p>
            </div>
        </div>
        @for ($i = 0; $i < 20; $i++)
            <x-card class="relative">
                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                    <div class="space-y-1 text-sm">
                        <p class="font-semibold xl:hidden">{{ __('Product') }}</p>
                        <p>
                            <a href="#" class="after:absolute after:inset-0 after:z-[1]">Lorem, ipsum dolor.</a>
                        </p>
                    </div>
                    <div class="space-y-1 text-sm xl:col-span-2">
                        <p class="font-semibold xl:hidden">{{ __('Opportunity / Project') }}</p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                    <div class="space-y-1 text-sm">
                        <p class="font-semibold xl:hidden">{{ __('Technical Supervisor') }}</p>
                        <p>John Doe</p>
                    </div>
                    <div class="space-y-1 text-sm">
                        <p class="font-semibold xl:hidden">{{ __('Repaired date') }}</p>
                        <time datetime="">02-Dec-2024</time>
                    </div>
                </div>
            </x-card>
        @endfor
    </section>
</div>
