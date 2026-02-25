<x-guest-layout>
    <div class="w-full max-w-md glass-card p-8">
        <h1 class="neo-heading text-2xl">Reset šifre</h1>
        <p class="neo-subtitle mt-2">Unesite email i poslat ćemo vam link za novu šifru.</p>

        @if (session('status'))
            <div class="mt-4 glass-alert-success text-sm">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mt-4 glass-alert-error" />

        <form method="POST" action="{{ route('password.email') }}" class="mt-4 space-y-4">
            @csrf
            <div>
                <x-jet-label for="email" class="text-gray-300" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="neo-input" type="email" name="email" :value="old('email')" required autofocus />
            </div>
            <div class="flex justify-end">
                <button type="submit" class="neo-button-primary">
                    {{ __('Pošalji reset link') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
