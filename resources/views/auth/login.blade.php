<x-layout-guest>
    <x-slot:title>{{ __('Login') }}</x-slot:title>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <x-form 
        method="POST" 
        action="{{ route('login.authenticate') }}" 
        data-element="login-form"
    >
        <div>
            <x-input-label for="username" :value="__('Hermes username or registered email address')" />
            <x-input 
                id="username" 
                class="mt-1" 
                type="text" 
                name="username" 
                :value="old('username')" 
                required 
                autofocus 
                autocomplete="username" 
            />
        </div>
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-input 
                id="password" 
                class="mt-1"
                type="password"
                name="password"
                required autocomplete="current-password" 
            />
        </div>
        <div class="mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <x-input-checkbox 
                    id="remember_me"
                    name="remember"
                />
                <span class="text-sm text-gray-600 ms-2">{{ __('Remember me') }}</span>
            </label>
        </div>
        <x-input-error :messages="$errors->get('username')" class="mt-2" />
        <div class="mt-4">
            <a href="{{ route('password.request') }}" class="text-sm">{{ __('Forgot password?') }}</a>
        </div>
        <div class="flex justify-end mt-4">
            <x-button
                variant="primary"
                class="g-recaptcha"
                data-sitekey="{{ config('app.recaptcha_v3.site_key') }}"
                data-callback="onSubmit"
                data-action="login"
                x-bind:disabled="submitting"
            >{{ __('Log in') }}</x-button>
        </div>
        <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2" />
    </x-form>
</x-layout-guest>
