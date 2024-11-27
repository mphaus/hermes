<x-layout-guest>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Enter the email address associated with :app_name and the system will email you a password reset link. This message should arrive in under five minutes, but may be in your spam folder.', ['app_name' => config('app.name')]) }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @unless (session('status') === 'We have emailed your password reset link.')
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button variant="primary">
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    @endunless
</x-layout-guest>
