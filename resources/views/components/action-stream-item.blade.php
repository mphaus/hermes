@php
    $url = $subjectUrl($action['action_type']);
@endphp
<x-card>
    <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-[28rem_1fr_1fr_1fr_1fr_1fr] xl:items-center xl:gap-3">
        @if ($url === '')
            <p class="mb-2 sm:col-span-2 lg:col-span-4 xl:col-span-1 xl:mb-0">{{ $action['name'] }}</p>    
        @else
            <a 
                href="{{ $url }}" 
                class="block mb-2 sm:col-span-2 lg:col-span-4 xl:col-span-1 xl:mb-0"
                target="_blank"
            >
                {{ $action['name'] }}
            </a>    
        @endif
        <div class="flex flex-col gap-1 text-sm">
            <p class="font-semibold xl:hidden">{{ __('User') }}</p>
            <p>{{ $action['member']['name'] }}</p>
        </div>
        <div class="flex flex-col gap-1 text-sm">
            <p class="font-semibold xl:hidden">{{ __('Action') }}</p>
            <p>{{ $actionType($action['action_type']) }}</p>
        </div>
        <div class="flex flex-col gap-1 text-sm xl:col-span-2">
            <p class="font-semibold xl:hidden">{{ __('Description') }}</p>
            <div>{{ $action['description'] }}</div>
        </div>
        <div class="flex flex-col gap-1 text-sm">
            <p class="font-semibold xl:hidden">{{ __('Date') }}</p>
            <time datetime="{{ $action['updated_at'] }}" class="block">{{ now()->parse($action['updated_at'])->timezone(config('app.timezone'))->format('d-M-Y H:i') }}</time>
        </div>
    </div>
</x-card>
