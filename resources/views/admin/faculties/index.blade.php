<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="neo-heading text-2xl">Admin panel - fakulteti</h2>
            <a href="{{ route('admin.applications.index') }}" class="neo-button-secondary text-sm">Nazad na prijave</a>
        </div>
    </x-slot>

    <div class="space-y-5">
        @if (session('status'))
            <div class="glass-card p-4 text-sm text-green-300">
                {{ session('status') }}
            </div>
        @endif

        <div class="glass-card p-6 overflow-x-auto">
            <table class="app-table">
                <thead>
                    <tr>
                        <th class="text-left py-2">Naziv</th>
                        <th class="text-left py-2">Slug</th>
                        <th class="text-left py-2">Kontakt</th>
                        <th class="text-left py-2">Odsjeci</th>
                        <th class="text-left py-2">Akcija</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($faculties as $faculty)
                        <tr>
                            <td class="py-2">{{ $faculty->name }}</td>
                            <td class="py-2">{{ $faculty->slug }}</td>
                            <td class="py-2">{{ $faculty->contact_email ?: '-' }}</td>
                            <td class="py-2">{{ $faculty->departments_count }}</td>
                            <td class="py-2">
                                <a href="{{ route('admin.faculties.edit', $faculty) }}" class="app-link">Uredi</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-gray-300">Nema dostupnih fakulteta.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

