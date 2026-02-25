<x-guest-layout>
    <div class="w-full max-w-md glass-card p-8" x-data="{ recovery: false }">
        <h1 class="neo-heading text-2xl">2FA provjera</h1>
        <div class="mt-2 text-sm text-gray-300" x-show="! recovery">
            {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
        </div>
        <div class="mt-2 text-sm text-gray-300" x-show="recovery">
            {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
        </div>

        <x-jet-validation-errors class="mt-4 glass-alert-error" />

        <form method="POST" action="{{ route('two-factor.login') }}" class="mt-4 space-y-4">
            @csrf

            <div x-show="! recovery">
                <x-jet-label for="code" class="text-gray-300" value="{{ __('Code') }}" />
                <x-jet-input id="code" class="neo-input" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
            </div>

            <div x-show="recovery">
                <x-jet-label for="recovery_code" class="text-gray-300" value="{{ __('Recovery Code') }}" />
                <x-jet-input id="recovery_code" class="neo-input" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
            </div>

            <div class="flex items-center justify-between gap-3 pt-1">
                <button type="button" class="text-sm text-blue-300 hover:text-blue-200"
                    x-show="! recovery"
                    x-on:click="recovery = true; $nextTick(() => { $refs.recovery_code.focus() })">
                    {{ __('Use a recovery code') }}
                </button>

                <button type="button" class="text-sm text-blue-300 hover:text-blue-200"
                    x-show="recovery"
                    x-on:click="recovery = false; $nextTick(() => { $refs.code.focus() })">
                    {{ __('Use an authentication code') }}
                </button>

                <button class="neo-button-primary">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
