<x-guest-layout>
    <div class="w-full max-w-xl glass-card p-8">
        <h1 class="neo-heading text-2xl">Potvrda emaila</h1>
        <p class="neo-subtitle mt-2">
            Potrebno je potvrditi email adresu prije nastavka. Provjerite inbox i kliknite verifikacijski link.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mt-4 glass-alert-success text-sm">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="neo-button-primary">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="neo-button-secondary text-sm">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
