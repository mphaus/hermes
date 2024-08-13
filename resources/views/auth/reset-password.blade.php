<x-layout-guest>
    <form method="POST" action="{{ route('password.store') }}" x-data="ResetPasswordForm">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email', $request->email)" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-input id="password" class="block w-full mt-1" type="password" name="password" required autofocus autocomplete="new-password" x-model="password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-input id="password_confirmation" class="block w-full mt-1"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" x-model="passwordConfirm" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4 space-y-4 text-sm">
            <div class="flex items-center gap-2">
                <p>{{ __('A unique and secure password is required.') }}</p>
                <x-icon-shushing-face class="w-5 h-5" />
            </div>
            <ul class="pl-5 space-y-1 list-disc">
                <li class="text-red-500" x-bind:class="{ '!text-green-600' : hasCorrectLength }">{{ __('12 to 24 characters') }}</li>
                <li>
                    {{ __('At least') }}
                    <ul class="list-[circle] pl-7 space-y-1">
                        <li class="text-red-500" x-bind:class="{ '!text-green-600' : hasTwoUppercaseLetters }">{{ __('2 uppercase letters') }}</li>
                        <li class="text-red-500" x-bind:class="{ '!text-green-600' : hasTwoLowercaseLetters }">{{ __('2 lowercase letters') }}</li>
                        <li class="text-red-500" x-bind:class="{ '!text-green-600' : hasTwoNumbers }">{{ __('2 numbers') }}</li>
                        <li class="text-red-500" x-bind:class="{ '!text-green-600' : hasTwoSpecialCharacters }">{{ __('2 special characters (!@#$%^&*()\-_+=)') }}</li>
                    </ul>
                </li>
            </ul>
            <p>{{ __('Passwords suggested by Password Managers (eg, 1Password) are ideal - be sure to save the password in your Password Manager as well!') }}</p>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button variant="primary" disabled x-bind:disabled="submitDisabled">
                {{ __('Reset Password') }}
            </x-button>
        </div>
    </form>
</x-layout-guest>
