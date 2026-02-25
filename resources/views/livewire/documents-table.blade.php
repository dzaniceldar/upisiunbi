<div class="glass-card p-6">
    <h3 class="text-lg font-semibold mb-3 text-white">Moji dokumenti</h3>
    <div class="space-y-2">
        @forelse($documents as $document)
            <div class="flex justify-between rounded-xl border border-gray-700 bg-gray-800 bg-opacity-60 p-3">
                <div>
                    <p class="font-medium text-white">{{ $document->original_name }}</p>
                    <p class="text-sm text-gray-400">{{ $document->type }} | {{ number_format($document->size / 1024, 2) }} KB</p>
                </div>
                <a href="{{ route('applicant.documents.download', $document) }}" class="app-link">Preuzmi</a>
            </div>
        @empty
            <p class="text-sm text-gray-400">Trenutno nema uploadovanih dokumenata.</p>
        @endforelse
    </div>
</div>
