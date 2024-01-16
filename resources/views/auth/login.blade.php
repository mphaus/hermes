<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('login.authenticate') }}" data-element="login-form">
        @csrf
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input 
                id="username" 
                class="block w-full mt-1" 
                type="text" 
                name="username" 
                :value="old('username')" 
                required 
                autofocus 
                autocomplete="username" 
            />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input 
                id="password" 
                class="block w-full mt-1"
                type="password"
                name="password"
                required autocomplete="current-password" 
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500" name="remember">
                <span class="text-sm text-gray-600 ms-2">{{ __('Remember me') }}</span>
            </label>
        </div>
        <div class="flex justify-end mt-4">
            <x-primary-button
                class="g-recaptcha"
                data-sitekey="{{ config('app.recaptcha_v3.site_key') }}"
                data-callback="onSubmit"
                data-action="login"
            >
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2" />
    </form>
</x-guest-layout>
