<x-app-layout>
    <x-slot name="header">
        <div class="overflow-hidden rounded-xl border border-gray-700 bg-gray-900 bg-opacity-80">
            <marquee behavior="scroll" direction="left" scrollamount="6" class="px-2 py-2 text-sm font-medium uppercase tracking-wide text-blue-300">
                PRVI UPISNI ROK - 10.06.2026 - 25.06.2026 • PRVI UPISNI ROK - 10.06.2026 - 25.06.2026 • PRVI UPISNI ROK - 10.06.2026 - 25.06.2026
            </marquee>
        </div>
    </x-slot>

    <div class="space-y-6" x-data="{ activeGuide: 1 }">
        <section class="grid gap-4 lg:grid-cols-2">
            <div class="overflow-hidden rounded-3xl border border-gray-700 min-h-[420px] lg:min-h-[560px]">
                <img src="{{ asset('images/unbi-login-slika.png') }}" alt="Univerzitet u Bihaću" class="h-full w-full object-cover">
            </div>

            <div class="glass-card p-7 md:p-10 flex flex-col justify-between">
                <div>
                    <p class="app-kicker">Dobrodošli na upisiunbi</p>
                    <h1 class="mt-3 text-3xl md:text-4xl font-extrabold tracking-tight text-white leading-tight">
                        Vodič za uspješan upis.
                    </h1>
                    <p class="mt-3 text-sm md:text-base text-gray-300">
                        Pratite korake ispod i završite prijavu brzo, tačno i bez nepotrebnih grešaka.
                    </p>

                    <div class="mt-5 grid grid-cols-2 gap-2">
                        <button type="button" @click="activeGuide = 1" :class="activeGuide === 1 ? 'border-blue-500 bg-blue-900 bg-opacity-40 text-blue-200' : 'border-gray-700 bg-gray-900 bg-opacity-60 text-gray-300'" class="rounded-xl border px-3 py-2 text-left text-xs md:text-sm transition">
                            1. Izbor studija
                        </button>
                        <button type="button" @click="activeGuide = 2" :class="activeGuide === 2 ? 'border-blue-500 bg-blue-900 bg-opacity-40 text-blue-200' : 'border-gray-700 bg-gray-900 bg-opacity-60 text-gray-300'" class="rounded-xl border px-3 py-2 text-left text-xs md:text-sm transition">
                            2. Dokumenti
                        </button>
                        <button type="button" @click="activeGuide = 3" :class="activeGuide === 3 ? 'border-blue-500 bg-blue-900 bg-opacity-40 text-blue-200' : 'border-gray-700 bg-gray-900 bg-opacity-60 text-gray-300'" class="rounded-xl border px-3 py-2 text-left text-xs md:text-sm transition">
                            3. Slanje prijave
                        </button>
                        <button type="button" @click="activeGuide = 4" :class="activeGuide === 4 ? 'border-blue-500 bg-blue-900 bg-opacity-40 text-blue-200' : 'border-gray-700 bg-gray-900 bg-opacity-60 text-gray-300'" class="rounded-xl border px-3 py-2 text-left text-xs md:text-sm transition">
                            4. Praćenje statusa
                        </button>
                    </div>

                    <div class="mt-4 rounded-xl border border-gray-700 bg-gray-900 bg-opacity-70 p-4 text-sm md:text-base text-gray-300 text-justify">
                        <p x-show="activeGuide === 1">
                            - Otvorite listu svih fakulteta i odsjeka, zatim detaljno uporedite uslove upisa i način bodovanja za svaki studijski program.<br>
                            - Provjerite koji predmeti i koje ocjene nose najveći broj bodova kako biste imali realnu procjenu svojih šansi za upis.<br>
                            - Fokusirajte se na smjer koji je usklađen sa vašim prethodnim obrazovanjem, interesima i dugoročnim profesionalnim ciljevima.
                        </p>
                        <p x-show="activeGuide === 2">
                            - Pripremite sve obavezne dokumente u jasno čitljivom PDF ili JPG formatu (lični dokument, svjedodžbe/diplomu i ostale priloge).<br>
                            - Provjerite da su svi skenovi potpuni, bez odrezanih rubova i da su podaci (ime, prezime, datumi i ocjene) vidljivi bez uvećavanja.<br>
                            - Prije slanja dokumentacije provjerite posebne zahtjeve odsjeka, jer određeni programi mogu tražiti dodatne potvrde ili obrasce.
                        </p>
                        <p x-show="activeGuide === 3">
                            - Prijavu popunite pažljivo i tačno, posebno lične podatke, kontakt informacije i odabrani fakultet/odsjek.<br>
                            - Prije konačnog slanja još jednom pregledajte unesene ocjene i uploadovane dokumente kako biste izbjegli naknadne ispravke.<br>
                            - Preporučeno je da prijavu završite nekoliko dana prije isteka roka, kako biste imali dovoljno vremena za eventualne tehničke korekcije.
                        </p>
                        <p x-show="activeGuide === 4">
                            - Nakon slanja prijave redovno pratite status u sistemu i obratite pažnju na eventualne obavijesti ili administrativne napomene.<br>
                            - Ako dobijete zahtjev za dopunu, dokumente ažurirajte što prije kako obrada ne bi bila odgođena pred kraj upisnog roka.<br>
                            - Čuvajte potvrdu o prijavi i pratite objave rezultata kako biste na vrijeme završili naredne korake upisa.
                        </p>
                    </div>
                </div>

                <div class="mt-8 flex flex-wrap gap-3">
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.applications.index') }}" class="neo-button-primary">Pregled prijava</a>
                    @else
                        <a href="{{ route('applications.index') }}" class="neo-button-primary">Započni prijavu</a>
                        <a href="{{ route('applicant.documents.index') }}" class="neo-button-secondary">Dokumenti</a>
                    @endif
                    <a href="{{ route('faculties.index') }}" class="neo-button-secondary">Svi fakulteti</a>
                </div>
            </div>
        </section>

        <section class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-gray-600 bg-gray-900 bg-opacity-70 p-4 transition hover:-translate-y-1 hover:border-blue-400">
                <p class="text-xs uppercase tracking-wide text-gray-400">Fakulteti</p>
                <p class="mt-2 text-3xl font-bold text-white">{{ $stats['faculties'] }}</p>
            </div>
            <div class="rounded-2xl border border-gray-600 bg-gray-900 bg-opacity-70 p-4 transition hover:-translate-y-1 hover:border-blue-400">
                <p class="text-xs uppercase tracking-wide text-gray-400">Odsjeci</p>
                <p class="mt-2 text-3xl font-bold text-white">{{ $stats['departments'] }}</p>
            </div>
            <div class="rounded-2xl border border-gray-600 bg-gray-900 bg-opacity-70 p-4 transition hover:-translate-y-1 hover:border-blue-400">
                <p class="text-xs uppercase tracking-wide text-gray-400">Predmeti</p>
                <p class="mt-2 text-3xl font-bold text-white">{{ $stats['subjects'] }}</p>
            </div>
            <div class="rounded-2xl border border-gray-600 bg-gray-900 bg-opacity-70 p-4 transition hover:-translate-y-1 hover:border-blue-400">
                <p class="text-xs uppercase tracking-wide text-gray-400">Ukupan broj studenata koji su završili UNBI</p>
                <p class="mt-2 text-3xl font-bold text-white">{{ $stats['graduates'] }}</p>
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-3 items-start">
            <div class="glass-card p-6 lg:col-span-2">
                <h3 class="text-lg font-semibold text-white">O Univerzitetu u Bihaću</h3>
                <div class="mt-4 space-y-3 text-sm text-gray-300 text-justify">
                    <p>
                        Univerzitet u Bihaću predstavlja centralnu visokoškolsku instituciju Unsko-sanskog kantona i okuplja različite fakultete i studijske programe koji odgovaraju savremenim akademskim i tržišnim potrebama.
                    </p>
                    <p>
                        Kroz kombinaciju teorijskog znanja i praktičnog rada, studenti stiču kompetencije koje su važne za profesionalni razvoj, nastavak školovanja i aktivno uključivanje u društveni i privredni život.
                    </p>
                    <p>
                        Poseban fokus Univerziteta je na kvalitetu nastave, digitalizaciji procesa i transparentnoj komunikaciji sa studentima, što online upis čini jednostavnijim, bržim i pristupačnijim svim kandidatima.
                    </p>
                    <p>
                        Zvanična stranica Univerziteta: <span class="text-blue-300 font-medium">www.unbi.ba</span> |
                        Adresa: <span class="text-blue-300 font-medium">Pape Ivana Pavla II 2, 77000 Bihać</span> |
                        Email: <span class="text-blue-300 font-medium">info@unbi.ba</span>
                    </p>
                </div>
            </div>

            <div class="glass-card p-6">
                <h3 class="text-lg font-semibold text-white">Statistika univerziteta</h3>
                <div class="mt-4 space-y-3 text-sm text-gray-300">
                    <div class="flex items-center justify-between rounded-lg border border-gray-700 bg-gray-900 bg-opacity-60 px-3 py-2">
                        <span>Ukupan broj diplomanata</span>
                        <span class="font-semibold text-blue-300">{{ $stats['graduates'] }}</span>
                    </div>
                    <div class="h-2 rounded-full bg-gray-800">
                        <div class="h-2 rounded-full bg-blue-500 w-4/5"></div>
                    </div>
                    <div class="flex items-center justify-between rounded-lg border border-gray-700 bg-gray-900 bg-opacity-60 px-3 py-2">
                        <span>Trenutni studenti - Dodiplomski studij</span>
                        <span class="font-semibold text-blue-300">6850</span>
                    </div>
                    <div class="h-2 rounded-full bg-gray-800">
                        <div class="h-2 rounded-full bg-blue-500 w-3/4"></div>
                    </div>
                    <div class="flex items-center justify-between rounded-lg border border-gray-700 bg-gray-900 bg-opacity-60 px-3 py-2">
                        <span>Trenutni studenti - Master studij</span>
                        <span class="font-semibold text-blue-300">1240</span>
                    </div>
                    <div class="h-2 rounded-full bg-gray-800">
                        <div class="h-2 rounded-full bg-blue-500 w-2/5"></div>
                    </div>
                    <div class="flex items-center justify-between rounded-lg border border-gray-700 bg-gray-900 bg-opacity-60 px-3 py-2">
                        <span>Trenutni studenti - Doktorski studij</span>
                        <span class="font-semibold text-blue-300">310</span>
                    </div>
                    <div class="h-2 rounded-full bg-gray-800">
                        <div class="h-2 rounded-full bg-blue-500 w-1/4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
