<x-slot name="title">{{ __('Quarantine Stats') }}</x-slot>
<x-slot name="heading">{{ __('Quarantine Stats') }}</x-slot>
<div x-on:hermes:quarantine-stats-filter-change="console.log($event)">
    <x-quarantine-stats-filter />
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
