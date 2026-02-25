<x-guest-layout>
    <div class="w-full max-w-5xl rounded-3xl bg-white shadow-xl overflow-hidden border border-gray-200">
        <div class="grid lg:grid-cols-2">
            <div class="p-8 md:p-12">
                <div class="mb-8">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-full bg-gray-900 text-white flex items-center justify-center text-sm font-bold">UB</div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Univerzitet u Bihaću</p>
                            <p class="text-xs text-gray-400">upisiunbi</p>
                        </div>
                    </div>
                    <h1 class="mt-5 text-3xl font-bold text-gray-900">Registracija kandidata</h1>
                    <p class="mt-2 text-sm text-gray-500">Kreirajte svoj profil i započnite online prijavu za studiranje na Univerzitetu u Bihaću.</p>
                </div>

                <div class="mb-6 inline-flex rounded-xl bg-gray-100 p-1 text-sm">
                    <a href="{{ route('login') }}" class="px-4 py-2 text-gray-500 hover:text-gray-700">Prijava</a>
                    <span class="rounded-lg bg-white px-4 py-2 font-semibold text-gray-900 shadow">Registracija</span>
                </div>

                <x-jet-validation-errors class="mb-4 rounded-xl border border-gray-300 bg-gray-100 p-3 text-sm text-gray-800" />

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-jet-label for="name" class="text-gray-700" value="{{ __('Ime i prezime') }}" />
                        <x-jet-input id="name" class="mt-1 block w-full rounded-xl border-gray-200 bg-white" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>

                    <div>
                        <x-jet-label for="email" class="text-gray-700" value="{{ __('Email') }}" />
                        <x-jet-input id="email" class="mt-1 block w-full rounded-xl border-gray-200 bg-white" type="email" name="email" :value="old('email')" required />
                    </div>

                    <div>
                        <x-jet-label for="password" class="text-gray-700" value="{{ __('Šifra') }}" />
                        <x-jet-input id="password" class="mt-1 block w-full rounded-xl border-gray-200 bg-white" type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <div>
                        <x-jet-label for="password_confirmation" class="text-gray-700" value="{{ __('Potvrdi šifru') }}" />
                        <x-jet-input id="password_confirmation" class="mt-1 block w-full rounded-xl border-gray-200 bg-white" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="text-sm text-gray-600">
                            <x-jet-label for="terms">
                                <div class="flex items-center">
                                    <x-jet-checkbox name="terms" id="terms" />
                                    <div class="ml-2">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-gray-700 hover:text-black">'.__('Terms of Service').'</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-gray-700 hover:text-black">'.__('Privacy Policy').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-jet-label>
                        </div>
                    @endif

                    <button type="submit" class="w-full rounded-xl bg-gray-900 py-3 font-semibold text-white hover:bg-black transition">
                        {{ __('Kreiraj račun') }}
                    </button>
                </form>
            </div>

            <div class="hidden lg:block bg-gray-200">
                <img src="{{ asset('images/unbi-login-slika.png') }}" alt="Univerzitet u Bihaću" class="h-full w-full object-cover">
            </div>
        </div>
    </div>
</x-guest-layout>
