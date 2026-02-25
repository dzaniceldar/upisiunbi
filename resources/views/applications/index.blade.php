<x-app-layout>
    <x-slot name="header">
        <h2 class="neo-heading text-2xl">Prijava za upis</h2>
    </x-slot>

    <div class="space-y-5">
        <div class="glass-card p-6">
            <div class="grid sm:grid-cols-2 gap-3 text-sm">
                <p class="text-gray-300">Status prijave:
                    <span class="ml-2 font-semibold text-white">{{ $application->status }}</span>
                </p>
                <p class="text-gray-300">Ukupni bodovi:
                    <span class="ml-2 font-semibold text-blue-300">{{ $application->total_points }}</span>
                </p>
            </div>
        </div>
        @livewire('admission-wizard')
    </div>
</x-app-layout>
