<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FacultyManagementController extends Controller
{
    public function index()
    {
        $faculties = Faculty::withCount('departments')->orderBy('name')->get();

        return view('admin.faculties.index', compact('faculties'));
    }

    public function edit(Faculty $faculty)
    {
        return view('admin.faculties.edit', compact('faculty'));
    }

    public function update(Request $request, Faculty $faculty)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('faculties', 'slug')->ignore($faculty->id)],
            'description' => ['nullable', 'string'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'instructions' => ['nullable', 'string'],
            'document_instructions' => ['nullable', 'string'],
            'image_path' => ['nullable', 'string', 'max:255'],
        ]);

        if (empty($validated['slug'])) {
            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug ?: 'fakultet';
            $counter = 1;
            while (Faculty::where('slug', $slug)->where('id', '!=', $faculty->id)->exists()) {
                $slug = $baseSlug.'-'.$counter++;
            }
            $validated['slug'] = $slug;
        }

        $faculty->update($validated);

        return redirect()
            ->route('admin.faculties.index')
            ->with('status', 'Podaci o fakultetu su uspješno ažurirani.');
    }
}

