<div class="glass-card p-6 space-y-4">
    <h3 class="text-lg font-semibold text-white">Obavezni dokumenti za upis</h3>
    <p class="text-sm text-gray-300">
        Za nastavak procesa potrebno je uploadovati sve obavezne dokumente.
    </p>

    @foreach ($requiredDocumentTypes as $type => $label)
        <div wire:key="required-document-{{ $type }}" class="rounded-xl border border-gray-700 bg-gray-900 bg-opacity-60 p-4 space-y-3">
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
                <input type="file" wire:model="documentFiles.{{ $type }}" class="neo-input p-2" />
                @error('documentFiles.'.$type) <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <button wire:click="uploadRequiredDocument('{{ $type }}')" wire:loading.attr="disabled" class="neo-button-primary text-sm">
                <span wire:loading.remove wire:target="uploadRequiredDocument,documentFiles.{{ $type }}">Upload {{ $label }}</span>
                <span wire:loading wire:target="uploadRequiredDocument,documentFiles.{{ $type }}">Upload u toku...</span>
            </button>
        </div>
    @endforeach
</div>
