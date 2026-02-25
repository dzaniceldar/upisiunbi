<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $application = Application::with(['faculty', 'department', 'grades.subject'])
            ->firstOrCreate(
                ['user_id' => $request->user()->id],
                ['status' => 'Draft']
            );

        return view('applications.index', compact('application'));
    }
}
