<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="neo-heading text-2xl">Uredi fakultet</h2>
            <a href="{{ route('admin.faculties.index') }}" class="neo-button-secondary text-sm">Nazad</a>
        </div>
    </x-slot>

    <div class="glass-card p-6 space-y-4">
        @if ($errors->any())
            <div class="rounded-xl border border-red-500/40 bg-red-900/30 p-4 text-sm text-red-200">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.faculties.update', $faculty) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-300 mb-1">Naziv fakulteta</label>
                    <input type="text" name="name" value="{{ old('name', $faculty->name) }}" class="neo-input w-full" required>
                </div>
                <div>
                    <label class="block text-sm text-gray-300 mb-1">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $faculty->slug) }}" class="neo-input w-full">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-300 mb-1">Email kontakt</label>
                    <input type="email" name="contact_email" value="{{ old('contact_email', $faculty->contact_email) }}" class="neo-input w-full">
                </div>
                <div>
                    <label class="block text-sm text-gray-300 mb-1">Telefon kontakt</label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone', $faculty->contact_phone) }}" class="neo-input w-full">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-300 mb-1">Website</label>
                    <input type="text" name="website" value="{{ old('website', $faculty->website) }}" class="neo-input w-full">
                </div>
                <div>
                    <label class="block text-sm text-gray-300 mb-1">Putanja slike (npr. images/fakultet.png)</label>
                    <input type="text" name="image_path" value="{{ old('image_path', $faculty->image_path) }}" class="neo-input w-full">
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-1">Opis</label>
                <textarea name="description" rows="4" class="neo-input w-full">{{ old('description', $faculty->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-1">Upute za upis</label>
                <textarea name="instructions" rows="4" class="neo-input w-full">{{ old('instructions', $faculty->instructions) }}</textarea>
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-1">Upute za dokumente</label>
                <textarea name="document_instructions" rows="4" class="neo-input w-full">{{ old('document_instructions', $faculty->document_instructions) }}</textarea>
            </div>

            <div class="pt-2">
                <button type="submit" class="neo-button-primary">Sačuvaj izmjene</button>
            </div>
        </form>
    </div>
</x-app-layout>

