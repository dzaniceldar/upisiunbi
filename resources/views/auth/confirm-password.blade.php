<x-guest-layout>
    <div class="w-full max-w-md glass-card p-8">
        <h1 class="neo-heading text-2xl">Sigurnosna potvrda</h1>
        <p class="neo-subtitle mt-2">Unesite trenutnu šifru za nastavak.</p>

        <x-jet-validation-errors class="mt-4 glass-alert-error" />

        <form method="POST" action="{{ route('password.confirm') }}" class="mt-4 space-y-4">
            @csrf
            <div>
                <x-jet-label for="password" class="text-gray-300" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="neo-input" type="password" name="password" required autocomplete="current-password" autofocus />
            </div>
            <div class="flex justify-end">
                <button type="submit" class="neo-button-primary">
                    {{ __('Confirm') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
