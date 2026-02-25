<!DOCTYPE html>
<html lang="bs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fakulteti - UNBI</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="gradient-bg font-sans antialiased text-gray-100">
    <div class="page-shell pt-8">
        <div class="glass-card p-6 md:p-8 mb-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div>
                    <p class="app-kicker">Univerzitet u Bihaću</p>
                    <h1 class="neo-heading mt-2">Fakulteti</h1>
                    <p class="neo-subtitle mt-2">Istražite studijske programe i odsjeke za upisnu prijavu.</p>
                </div>
                <div class="flex gap-2 text-sm">
                    @auth
                        <a href="{{ route('dashboard') }}" class="neo-button-secondary">Naslovna</a>
                    @else
                        <a href="{{ route('login') }}" class="neo-button-secondary">Login</a>
                        <a href="{{ route('register') }}" class="neo-button-primary">Registracija</a>
                    @endauth
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($faculties as $faculty)
                <a href="{{ route('faculties.show', $faculty) }}" class="glass-card p-5 transition hover:bg-gray-700 hover:bg-opacity-40">
                    <h3 class="text-lg font-semibold text-white">{{ $faculty->name }}</h3>
                    <p class="text-sm text-gray-300 mt-2">{{ \Illuminate\Support\Str::limit($faculty->description, 140) }}</p>
                    <p class="text-xs uppercase tracking-wide text-blue-300 mt-4">Odsjeci: {{ $faculty->departments_count }}</p>
                </a>
            @endforeach
        </div>
    </div>
</body>
</html>
