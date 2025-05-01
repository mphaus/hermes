@props(['log'])

<x-card class="relative">
    <div class="grid gap-2 lg:grid-cols-3">
        <a 
            href="{{ route('logs.show', ['id' => $log->id]) }}" 
            title="{{ __('View log') }}" 
            class="absolute inset-0 z-1"
        ></a>
        <div class="grid grid-cols-[6rem_1fr] gap-1 text-sm lg:block">
            <p class="font-semibold lg:hidden">{{ __('Uploaded by') }}</p>
            <p>{{ $log->user->fullName }}</p>
        </div>
        <div class="grid grid-cols-[6rem_1fr] gap-1 text-sm lg:mt-0 lg:block">
            <p class="font-semibold lg:hidden">{{ __('Uploaded at') }}</p>
            <time datetime="{{ $log->created_at }}">{{ now()->parse($log->created_at)->timezone(config('app.timezone'))->format('d-M-Y') }}</time>
        </div>
        <div class="grid grid-cols-[6rem_1fr] gap-1 text-sm lg:mt-0 lg:block">
            <p class="font-semibold lg:hidden">{{ __('Status') }}</p>
            <p @class([
                'text-green-500' => $log->status === 'successful',
                'text-yellow-500' => $log->status === 'warnings',    
            ])>{{ str()->ucfirst($log->status) }}</p>
        </div>
    </div>
</x-card>
