<x-app-layout>
    <x-slot name="header">
        <h2 class="neo-heading text-2xl">Moji dokumenti</h2>
    </x-slot>

    <div class="space-y-5">
        @if (session('status'))
            <div class="glass-alert-success">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="glass-alert-error">{{ session('error') }}</div>
        @endif

        @if ($application)
            <div class="glass-card p-6 space-y-4">
                <h3 class="text-lg font-semibold text-white">Obavezni dokumenti za upis</h3>
                <p class="text-sm text-gray-300">
                    Potrebno je uploadovati sve obavezne dokumente. Status se ažurira odmah nakon uspješnog uploada.
                </p>

                @foreach ($requiredDocumentTypes as $type => $label)
                    <form method="POST" action="{{ route('applicant.documents.upload-required') }}" enctype="multipart/form-data" class="rounded-xl border border-gray-700 bg-gray-900 bg-opacity-60 p-4 space-y-3">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-sm font-medium text-white">{{ $label }}</p>
                            @if (in_array($type, $uploadedTypes, true))
                                <span class="text-xs font-semibold text-green-300">Učitano</span>
                            @else
                                <span class="text-xs font-semibold text-red-300">Nedostaje</span>
                            @endif
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1 text-gray-300">Datoteka (PDF/JPG/PNG)</label>
                            <input type="file" name="file" class="neo-input p-2" required>
                            @error('file')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="neo-button-primary text-sm">Upload {{ $label }}</button>
                    </form>
                @endforeach
            </div>
            @livewire('documents-table')
        @else
            <div class="glass-card p-4 text-gray-200">
                Prvo kreirajte prijavu za upis, zatim uploadujte dokumente.
            </div>
        @endif
    </div>
</x-app-layout>
