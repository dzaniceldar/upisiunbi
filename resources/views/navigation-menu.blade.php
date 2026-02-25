<nav x-data="{ open: false }" class="app-topbar">
    <div class="page-shell py-3">
        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded-xl border border-gray-600 bg-gray-800 px-3 py-2">
                <span class="h-2.5 w-2.5 rounded-full bg-blue-400"></span>
                <span class="text-sm font-semibold tracking-wide text-white">upisiunbi</span>
            </a>

            <div class="hidden lg:flex items-center gap-2">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'app-nav-link-active' : 'app-nav-link' }}">Naslovna</a>
                <a href="{{ route('faculties.index') }}" class="{{ request()->routeIs('faculties.*') ? 'app-nav-link-active' : 'app-nav-link' }}">Fakulteti</a>
                @if (Auth::user()->isApplicant())
                    <a href="{{ route('applications.index') }}" class="{{ request()->routeIs('applications.*') ? 'app-nav-link-active' : 'app-nav-link' }}">Prijava za upis</a>
                    <a href="{{ route('applicant.documents.index') }}" class="{{ request()->routeIs('applicant.documents.*') ? 'app-nav-link-active' : 'app-nav-link' }}">Moji dokumenti</a>
                @endif
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('admin.applications.index') }}" class="{{ request()->routeIs('admin.*') ? 'app-nav-link-active' : 'app-nav-link' }}">Admin</a>
                @endif
            </div>

            <div class="hidden lg:flex items-center gap-3">
                <a href="{{ route('profile.show') }}" class="neo-button-secondary text-sm">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="neo-button-primary text-sm">Odjava</button>
                </form>
            </div>

            <button @click="open = !open" class="lg:hidden neo-button-secondary px-3 py-2 text-sm">
                Meni
            </button>
        </div>
    </div>

    <div x-show="open" x-transition class="lg:hidden border-t border-gray-700 bg-gray-900 bg-opacity-95">
        <div class="page-shell py-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="block {{ request()->routeIs('dashboard') ? 'app-nav-link-active' : 'app-nav-link' }}">Naslovna</a>
            <a href="{{ route('faculties.index') }}" class="block {{ request()->routeIs('faculties.*') ? 'app-nav-link-active' : 'app-nav-link' }}">Fakulteti</a>
            @if (Auth::user()->isApplicant())
                <a href="{{ route('applications.index') }}" class="block {{ request()->routeIs('applications.*') ? 'app-nav-link-active' : 'app-nav-link' }}">Prijava za upis</a>
                <a href="{{ route('applicant.documents.index') }}" class="block {{ request()->routeIs('applicant.documents.*') ? 'app-nav-link-active' : 'app-nav-link' }}">Moji dokumenti</a>
            @endif
            @if (Auth::user()->isAdmin())
                <a href="{{ route('admin.applications.index') }}" class="block {{ request()->routeIs('admin.*') ? 'app-nav-link-active' : 'app-nav-link' }}">Admin</a>
            @endif
            <a href="{{ route('profile.show') }}" class="block app-nav-link">Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full neo-button-primary text-sm">Odjava</button>
            </form>
        </div>
    </div>
</nav>
