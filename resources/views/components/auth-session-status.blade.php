@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
        @if ($status === 'Your password has been reset.')
            <p>{{ __('Got it, your password has been changed, you can log in using it now.') }}</p>
        @else
            {{ $status }}    
        @endif
    </div>
@endif
