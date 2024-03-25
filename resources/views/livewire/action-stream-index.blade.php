<x-slot name="title">{{ __('Action Stream') }}</x-slot>
<x-slot name="heading">{{ __('Action Stream') }}</x-slot>
<div class="flow">
    <section class="hidden">
        <select name="" id="">
            <option value="">Matt Hansen</option>
            <option value="">Michael Parsons</option>
        </select>
        <select name="" id="">
            <option value="">Action 1</option>
            <option value="">Action 2</option>
        </select>
        <input type="date">
        <x-button variant="primary">Search</x-button>
        <x-button variant="primary">Last seven days</x-button>
        <x-button variant="primary">Last month</x-button>
    </section>
    <section class="space-y-4">
        <div class="hidden gap-2 px-6 text-sm font-semibold xl:grid grid-cols-[28rem_1fr_1fr_1fr_1fr_1fr]">
            <p>{{ __('Job') }}</p>
            <p>{{ __('User') }}</p>
            <p>{{ __('Action') }}</p>
            <p class="col-span-2">{{ __('Description') }}</p>
            <p>{{ __('Date') }}</p>
        </div>
        <x-card>
            <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-[28rem_1fr_1fr_1fr_1fr_1fr] xl:items-center">
                <p class="mb-2 sm:col-span-2 lg:col-span-4 xl:col-span-1 text-primary-500 xl:mb-0">DreamHack 2024 | CS:GO - MCA Production lighting hire - PO-3035</p>
                <div class="flex flex-col gap-1 text-sm">
                    <p class="font-semibold xl:hidden">{{ __('User') }}</p>
                    <p>Jesse Walsh</p>
                </div>
                <div class="flex flex-col gap-1 text-sm">
                    <p class="font-semibold xl:hidden">{{ __('Action') }}</p>
                    <p>Viewed</p>
                </div>
                <div class="flex flex-col gap-1 text-sm xl:col-span-2">
                    <p class="font-semibold xl:hidden">{{ __('Description') }}</p>
                    <div>Lorem ipsum dolor sit amet.</div>
                </div>
                <div class="flex flex-col gap-1 text-sm">
                    <p class="font-semibold xl:hidden">{{ __('Date') }}</p>
                    <time class="block">25-Mar-2024 22:09</time>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-[28rem_1fr_1fr_1fr_1fr_1fr] xl:items-center">
                <p class="mb-2 sm:col-span-2 lg:col-span-4 xl:col-span-1 text-primary-500 xl:mb-0">DreamHack 2024 | CS:GO - MCA Production lighting hire - PO-3035</p>
                <div class="flex flex-col gap-1 text-sm">
                    <p class="font-semibold xl:hidden">{{ __('User') }}</p>
                    <p>Jesse Walsh</p>
                </div>
                <div class="flex flex-col gap-1 text-sm">
                    <p class="font-semibold xl:hidden">{{ __('Action') }}</p>
                    <p>Viewed</p>
                </div>
                <div class="flex flex-col gap-1 text-sm xl:col-span-2">
                    <p class="font-semibold xl:hidden">{{ __('Description') }}</p>
                    <div>Lorem ipsum dolor sit amet.</div>
                </div>
                <div class="flex flex-col gap-1 text-sm">
                    <p class="font-semibold xl:hidden">{{ __('Date') }}</p>
                    <time class="block">25-Mar-2024 22:09</time>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-[28rem_1fr_1fr_1fr_1fr_1fr] xl:items-center">
                <p class="mb-2 sm:col-span-2 lg:col-span-4 xl:col-span-1 text-primary-500 xl:mb-0">DreamHack 2024 | CS:GO - MCA Production lighting hire - PO-3035</p>
                <div class="flex flex-col gap-1 text-sm">
                    <p class="font-semibold xl:hidden">{{ __('User') }}</p>
                    <p>Jesse Walsh</p>
                </div>
                <div class="flex flex-col gap-1 text-sm">
                    <p class="font-semibold xl:hidden">{{ __('Action') }}</p>
                    <p>Viewed</p>
                </div>
                <div class="flex flex-col gap-1 text-sm xl:col-span-2">
                    <p class="font-semibold xl:hidden">{{ __('Description') }}</p>
                    <div>Lorem ipsum dolor sit amet.</div>
                </div>
                <div class="flex flex-col gap-1 text-sm">
                    <p class="font-semibold xl:hidden">{{ __('Date') }}</p>
                    <time class="block">25-Mar-2024 22:09</time>
                </div>
            </div>
        </x-card>
    </section>
</div>
