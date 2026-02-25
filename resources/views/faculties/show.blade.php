<!DOCTYPE html>
<html lang="bs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $faculty->name }} - UNBI</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="gradient-bg font-sans antialiased text-gray-100">
    <div class="page-shell pt-8 space-y-5">
        <div class="glass-card p-6">
            <a href="{{ route('faculties.index') }}" class="text-sm app-link">&larr; Svi fakulteti</a>
            <h1 class="neo-heading mt-2">{{ $faculty->name }}</h1>
        </div>

        <div class="glass-card p-6">
            <p class="text-gray-300">{{ $faculty->description }}</p>
            <div class="mt-4 text-sm text-gray-400">
                <p>Email: {{ $faculty->contact_email }}</p>
                <p>Telefon: {{ $faculty->contact_phone }}</p>
                <p>Web: {{ $faculty->website }}</p>
            </div>
        </div>

        <div class="glass-card p-6">
            <h3 class="text-lg font-semibold text-white mb-3">Odsjeci</h3>
            <div class="space-y-2">
                @foreach ($faculty->departments as $department)
                    <div class="rounded-xl border border-gray-700 bg-gray-800 bg-opacity-60 p-3">
                        <p class="font-medium text-white">{{ $department->name }}</p>
                        <p class="text-sm text-gray-400">{{ $department->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
