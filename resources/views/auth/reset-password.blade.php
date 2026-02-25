<x-guest-layout>
    <div class="w-full max-w-md glass-card p-8">
        <h1 class="neo-heading text-2xl">Nova šifra</h1>
        <p class="neo-subtitle mt-2">Postavite novu lozinku za vaš nalog.</p>

        <x-jet-validation-errors class="mt-4 glass-alert-error" />

        <form method="POST" action="{{ route('password.update') }}" class="mt-4 space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <x-jet-label for="email" class="text-gray-300" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="neo-input" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <div>
                <x-jet-label for="password" class="text-gray-300" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="neo-input" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div>
                <x-jet-label for="password_confirmation" class="text-gray-300" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="neo-input" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex justify-end">
                <button type="submit" class="neo-button-primary">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
