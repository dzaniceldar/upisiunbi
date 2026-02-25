<x-app-layout>
    <x-slot name="header">
        <h2 class="neo-heading text-2xl">Prijava #{{ $application->id }}</h2>
    </x-slot>

    <div class="space-y-5">
        @if (session('status'))
            <div class="glass-alert-success">{{ session('status') }}</div>
        @endif

        <div class="glass-card p-6">
            <h3 class="font-semibold text-lg text-white mb-2">Podaci aplikanta</h3>
            <div class="grid md:grid-cols-2 gap-2 text-gray-300">
                <p>Ime: {{ $application->user->name }}</p>
                <p>Email: {{ $application->user->email }}</p>
                <p>Fakultet: {{ optional($application->faculty)->name }}</p>
                <p>Odsjek: {{ optional($application->department)->name }}</p>
                <p>Status: <span class="neo-badge-{{ \Illuminate\Support\Str::slug($application->status, '-') }}">{{ $application->status }}</span></p>
            </div>
        </div>

        <div class="glass-card p-6">
            <h3 class="font-semibold text-lg text-white mb-2">Bodovanje</h3>
            @foreach ($score['breakdown'] as $row)
                <div class="flex justify-between border-b border-gray-700 py-1 text-sm text-gray-300">
                    <span>{{ $row['subject'] }} ({{ $row['grade'] }} x {{ $row['weight'] }})</span>
                    <span>{{ $row['points'] }}</span>
                </div>
            @endforeach
            <p class="mt-2 font-semibold text-blue-300">Ukupno: {{ $score['total'] }}</p>
        </div>

        <div class="glass-card p-6">
            <h3 class="font-semibold text-lg text-white mb-2">Dokumenti</h3>
            <div class="space-y-2">
                @foreach ($application->documents as $document)
                    <div class="flex justify-between rounded-xl border border-gray-700 bg-gray-800 bg-opacity-60 p-2">
                        <span class="text-gray-300">{{ $document->type }} - {{ $document->original_name }}</span>
                        <a href="{{ route('admin.documents.download', $document) }}" class="app-link">Download</a>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="glass-card p-6">
            <h3 class="font-semibold text-lg text-white mb-2">Workflow status</h3>
            <form method="POST" action="{{ route('admin.applications.status', $application) }}" class="flex flex-wrap gap-2">
                @csrf
                <select name="status" class="neo-select md:max-w-sm">
                    @foreach (['Draft', 'Submitted', 'Under review', 'Accepted', 'Rejected', 'Needs correction'] as $status)
                        <option value="{{ $status }}" @if($application->status === $status) selected @endif>{{ $status }}</option>
                    @endforeach
                </select>
                <button class="neo-button-primary">Ažuriraj</button>
            </form>
        </div>

        <div class="glass-card p-6">
            <h3 class="font-semibold text-lg text-white mb-2">Admin napomene</h3>
            <form method="POST" action="{{ route('admin.applications.notes', $application) }}" class="space-y-2">
                @csrf
                <textarea name="note" rows="3" class="neo-input" placeholder="Unesite napomenu..."></textarea>
                <button class="neo-button-secondary">Dodaj napomenu</button>
            </form>
            <div class="mt-4 space-y-2">
                @foreach ($application->adminNotes as $note)
                    <div class="rounded-xl border border-gray-700 bg-gray-800 bg-opacity-60 p-3 text-sm">
                        <p class="text-gray-100">{{ $note->note }}</p>
                        <p class="text-gray-400 mt-1">{{ $note->admin->name }} | {{ $note->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
