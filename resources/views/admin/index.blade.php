<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="neo-heading text-2xl">Admin panel - prijave</h2>
            <a href="{{ route('admin.faculties.index') }}" class="neo-button-secondary text-sm">Uredi fakultete</a>
        </div>
    </x-slot>

    <div class="space-y-5">
        <div class="glass-card p-6">
            <form method="GET" class="grid md:grid-cols-3 xl:grid-cols-6 gap-3">
                <select name="faculty_id" class="neo-select">
                    <option value="">Svi fakulteti</option>
                    @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}" @if(request('faculty_id') == $faculty->id) selected @endif>{{ $faculty->name }}</option>
                    @endforeach
                </select>
                <select name="department_id" class="neo-select">
                    <option value="">Svi odsjeci</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @if(request('department_id') == $department->id) selected @endif>{{ $department->name }}</option>
                    @endforeach
                </select>
                <select name="status" class="neo-select">
                    <option value="">Svi statusi</option>
                    @foreach (['Draft', 'Submitted', 'Under review', 'Accepted', 'Rejected', 'Needs correction'] as $status)
                        <option value="{{ $status }}" @if(request('status') === $status) selected @endif>{{ $status }}</option>
                    @endforeach
                </select>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="neo-input" />
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="neo-input" />
                <button class="neo-button-secondary">Filtriraj</button>
                <a href="{{ route('admin.applications.export') }}" class="neo-button-primary text-center">Export CSV</a>
            </form>
        </div>

        <div class="glass-card p-6 overflow-x-auto">
            <table class="app-table">
                <thead>
                    <tr>
                        <th class="text-left py-2">ID</th>
                        <th class="text-left py-2">Aplikant</th>
                        <th class="text-left py-2">Fakultet</th>
                        <th class="text-left py-2">Odsjek</th>
                        <th class="text-left py-2">Status</th>
                        <th class="text-left py-2">Bodovi</th>
                        <th class="text-left py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                        <tr>
                            <td class="py-2">{{ $application->id }}</td>
                            <td class="py-2">{{ $application->user->name }}</td>
                            <td class="py-2">{{ optional($application->faculty)->name }}</td>
                            <td class="py-2">{{ optional($application->department)->name }}</td>
                            <td class="py-2">
                                <span class="neo-badge-{{ \Illuminate\Support\Str::slug($application->status, '-') }}">{{ $application->status }}</span>
                            </td>
                            <td class="py-2">{{ $application->total_points }}</td>
                            <td class="py-2"><a href="{{ route('admin.applications.show', $application) }}" class="app-link">Detalj</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $applications->links() }}</div>
        </div>
    </div>
</x-app-layout>
