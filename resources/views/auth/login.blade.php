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
                    <h1 class="mt-5 text-3xl font-bold text-gray-900">Dobrodošli nazad!</h1>
                    <p class="mt-2 text-sm text-gray-500">Prijavite se i nastavite vaše obrazovanje na Univerzitetu u Bihaću.</p>
                </div>

                <div class="mb-6 inline-flex rounded-xl bg-gray-100 p-1 text-sm">
                    <span class="rounded-lg bg-white px-4 py-2 font-semibold text-gray-900 shadow">Prijava</span>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-gray-500 hover:text-gray-700">Registracija</a>
                </div>

                <x-jet-validation-errors class="mb-4 rounded-xl border border-gray-300 bg-gray-100 p-3 text-sm text-gray-800" />

                @if (session('status'))
                    <div class="mb-4 rounded-xl border border-gray-300 bg-gray-100 p-3 text-sm text-gray-800">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-jet-label for="email" class="text-gray-700" value="{{ __('Email') }}" />
                        <x-jet-input id="email" class="mt-1 block w-full rounded-xl border-gray-200 bg-white" type="email" name="email" :value="old('email')" required autofocus />
                    </div>

                    <div>
                        <x-jet-label for="password" class="text-gray-700" value="{{ __('Šifra') }}" />
                        <x-jet-input id="password" class="mt-1 block w-full rounded-xl border-gray-200 bg-white" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label for="remember_me" class="flex items-center text-gray-600">
                            <x-jet-checkbox id="remember_me" name="remember" />
                            <span class="ml-2">{{ __('Zapamti me') }}</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-gray-700 hover:text-black" href="{{ route('password.request') }}">
                                {{ __('Zaboravili ste šifru?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full rounded-xl bg-gray-900 py-3 font-semibold text-white hover:bg-black transition">
                        {{ __('Nastavi') }}
                    </button>
                </form>
            </div>

            <div class="hidden lg:block bg-gray-200">
                <img src="{{ asset('images/unbi-login-slika.png') }}" alt="Univerzitet u Bihaću" class="h-full w-full object-cover">
            </div>
        </div>
    </div>
</x-guest-layout>
