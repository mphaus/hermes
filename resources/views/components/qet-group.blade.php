@props(['group'])

<div class="space-y-8">
    <p class="flex flex-col gap-1">
        <span class="font-semibold">{{ $group['job']['subject'] }}</span>
        <span class="flex items-center text-xs">
            (<x-icon-arrow-up class="w-3 h-3 fill-blue-600" />
            <span class="block ml-1">at {{ now()->parse($group['job']['date'])->format('Hi D M d') }}</span>)
        </span>
    </p>
    <div class="space-y-4">
        <div class="hidden lg:block">
            <div class="grid grid-cols-8 px-6 text-sm font-semibold">
                <p class="col-span-3">{{ __('Coming off Job') }}</p>
                <p class="col-span-3">{{ __('Item') }}</p>
                <p>{{ __('Count') }}</p>
                <p>{{ __('Time remaining') }}</p>
            </div>
        </div>
        @foreach ($group['items'] as $item)
            <x-qet-item :item="$item" :end-date="$group['job']['date']" wire:key="{{ $item['id'] }}" />
        @endforeach
    </div>
</div>
