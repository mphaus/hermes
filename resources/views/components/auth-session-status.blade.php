@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
        @if ($status === 'Your password has been reset.')
            <p>{{ __('Got it, your password has been changed, you can log in using it now.') }}</p>
        @elseif ($status === 'We have emailed your password reset link.')
            <p>{{ __('We have emailed your password reset link. Please follow the instructions in the email. This tab can be closed now.') }}</p>
        @else
            {{ $status }}    
        @endif
    </div>
@endif
