<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminNoteRequest;
use App\Http\Requests\UpdateApplicationStatusRequest;
use App\Models\AdminNote;
use App\Models\Application;
use App\Models\Department;
use App\Models\Document;
use App\Models\Faculty;
use App\Services\ScoringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::with(['user', 'faculty', 'department'])->latest();

        if ($request->filled('faculty_id')) {
            $query->where('faculty_id', $request->faculty_id);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $applications = $query->paginate(20)->withQueryString();
        $faculties = Faculty::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();

        return view('admin.index', compact('applications', 'faculties', 'departments'));
    }

    public function show(Application $application, ScoringService $scoringService)
    {
        $application->load([
            'user',
            'faculty',
            'department',
            'grades.subject',
            'documents',
            'adminNotes.admin',
        ]);

        $score = $scoringService->calculate($application);

        return view('admin.show', [
            'application' => $application,
            'score' => $score,
        ]);
    }

    public function updateStatus(UpdateApplicationStatusRequest $request, Application $application)
    {
        $status = $request->status;
        $application->status = $status;
        if ($status === 'Submitted') {
            $application->submitted_at = now();
            $application->locked_at = now();
        }
        if ($status === 'Needs correction') {
            $application->locked_at = null;
        }
        $application->save();

        return back()->with('status', 'Status prijave je uspješno ažuriran.');
    }

    public function storeNote(StoreAdminNoteRequest $request, Application $application)
    {
        AdminNote::create([
            'application_id' => $application->id,
            'admin_user_id' => $request->user()->id,
            'note' => $request->note,
        ]);

        return back()->with('status', 'Admin napomena je spašena.');
    }

    public function exportCsv(Request $request)
    {
        $applications = Application::with(['user', 'faculty', 'department'])->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="prijave.csv"',
        ];

        $callback = function () use ($applications) {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['ID', 'Aplikant', 'Email', 'Fakultet', 'Odsjek', 'Status', 'Bodovi', 'Predano']);
            foreach ($applications as $application) {
                fputcsv($output, [
                    $application->id,
                    $application->user->name,
                    $application->user->email,
                    optional($application->faculty)->name,
                    optional($application->department)->name,
                    $application->status,
                    $application->total_points,
                    optional($application->submitted_at)->format('Y-m-d H:i'),
                ]);
            }
            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadDocument(Document $document)
    {
        return Storage::download($document->path, $document->original_name);
    }
}
