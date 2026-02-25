<?php

namespace App\Http\Controllers;

use App\Models\Faculty;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = Faculty::withCount('departments')->orderBy('name')->get();

        return view('faculties.index', compact('faculties'));
    }

    public function show(Faculty $faculty)
    {
        $faculty->load('departments');

        return view('faculties.show', compact('faculty'));
    }
}
