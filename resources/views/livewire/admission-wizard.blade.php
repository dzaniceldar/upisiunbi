<div class="space-y-6">
    @if (session('status'))
        <div class="glass-alert-success">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="glass-alert-error">{{ session('error') }}</div>
    @endif

    <div class="glass-card p-6 space-y-4">
        <h3 class="text-lg font-semibold text-white">Prijava za upis</h3>

        <div>
            <label class="block text-sm font-medium mb-1 text-gray-300">Fakultet</label>
            <select wire:model="facultyId" class="neo-select">
                <option value="">Odaberite fakultet</option>
                @foreach ($faculties as $faculty)
                    <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                @endforeach
            </select>
            @error('facultyId') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1 text-gray-300">Odsjek / Smjer</label>
            <select wire:model="departmentId" class="neo-select">
                <option value="">Odaberite odsjek</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
            @error('departmentId') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        @if ($selectedFaculty)
            <div class="rounded-xl border border-blue-700 bg-blue-900 bg-opacity-40 p-3 text-sm text-blue-100">
                <p class="font-semibold">Upute za bodovanje:</p>
                <p>{{ $selectedFaculty->instructions }}</p>
                @if ($selectedDepartment && $selectedDepartment->instructions)
                    <p class="mt-2 font-semibold">Upute za odsjek:</p>
                    <p>{{ $selectedDepartment->instructions }}</p>
                @endif
                <p class="mt-2 font-semibold">Upute za dokumente:</p>
                <p>{{ $selectedFaculty->document_instructions }}</p>
            </div>
        @endif
    </div>

    @if (count($subjects))
        <div class="glass-card p-6 space-y-3">
            <h4 class="text-md font-semibold text-white">Predmeti i ocjene</h4>
            @foreach ($subjects as $subject)
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-300">{{ $subject->name }}</label>
                    <input wire:model.defer="grades.{{ $subject->id }}" type="number" min="1" max="5" step="0.01" class="neo-input" />
                    @error('grades.'.$subject->id) <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            @endforeach
        </div>
    @endif

    @if (count($breakdown))
        <div class="glass-card p-6">
            <h4 class="text-md font-semibold mb-3 text-white">Pregled bodovanja</h4>
            <div class="space-y-2 text-sm text-gray-300">
                @foreach ($breakdown as $row)
                    <div class="flex justify-between border-b border-gray-700 pb-1">
                        <span>{{ $row['subject'] }} (ocjena {{ $row['grade'] }}, težina {{ $row['weight'] }})</span>
                        <span class="font-medium">{{ $row['points'] }} bodova</span>
                    </div>
                @endforeach
            </div>
            <p class="mt-3 font-semibold text-blue-300">Ukupno: {{ $totalPoints }} bodova</p>
        </div>
    @endif

    <div class="flex gap-3">
        <button wire:click="saveDraft" wire:loading.attr="disabled" class="neo-button-secondary">
            <span wire:loading.remove wire:target="saveDraft">Sačuvaj draft</span>
            <span wire:loading wire:target="saveDraft">Spašavanje...</span>
        </button>
        <button wire:click="submit" wire:loading.attr="disabled" class="neo-button-primary">
            <span wire:loading.remove wire:target="submit">Pošalji prijavu</span>
            <span wire:loading wire:target="submit">Slanje...</span>
        </button>
    </div>
</div>
