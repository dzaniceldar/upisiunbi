<?php

namespace App\Http\Livewire;

use App\Models\Application;
use App\Models\ApplicationGrade;
use App\Models\Department;
use App\Models\Faculty;
use App\Services\GradeExtractionService;
use App\Services\ScoringService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class AdmissionWizard extends Component
{
    use AuthorizesRequests;

    private const REQUIRED_DOCUMENT_TYPES = [
        'licna_karta' => 'Lična karta / pasoš',
        'svjedodzba' => 'Svjedodžba',
        'rodni_list' => 'Rodni list',
        'dokaz_o_uplati' => 'Dokaz o uplati',
    ];

    public $application;
    public $facultyId;
    public $departmentId;
    public $grades = [];
    public $departments = [];
    public $subjects = [];
    public $breakdown = [];
    public $totalPoints = 0;

    protected $listeners = ['documentUploaded' => 'processUploadedDocument'];

    public function mount()
    {
        $this->application = Application::firstOrCreate(
            ['user_id' => auth()->id()],
            ['status' => 'Draft']
        );

        $this->authorize('view', $this->application);

        $this->facultyId = $this->application->faculty_id;
        $this->departmentId = $this->application->department_id;
        $this->loadDepartments();
        $this->loadSubjects();
        $this->loadCurrentGrades();
        $this->refreshScore();
    }

    public function updatedFacultyId()
    {
        if (! $this->isEditable()) {
            return;
        }

        $this->departmentId = null;
        $this->subjects = [];
        $this->grades = [];
        $this->loadDepartments();
    }

    public function updatedDepartmentId()
    {
        if (! $this->isEditable()) {
            return;
        }

        $this->loadSubjects();
        $this->grades = [];
    }

    public function saveDraft()
    {
        $scoringService = app(ScoringService::class);
        if (! $this->isEditable()) {
            session()->flash('error', 'Prijava je zaključana. Obratite se studentskoj službi.');
            return;
        }

        $this->validate([
            'facultyId' => 'required|exists:faculties,id',
            'departmentId' => 'required|exists:departments,id',
            'grades.*' => 'nullable|numeric|min:1|max:5',
        ], [], ['facultyId' => 'fakultet', 'departmentId' => 'odsjek']);

        $this->application->update([
            'faculty_id' => $this->facultyId,
            'department_id' => $this->departmentId,
            'status' => $this->application->status === 'Needs correction' ? 'Needs correction' : 'Draft',
        ]);

        foreach ($this->subjects as $subject) {
            ApplicationGrade::updateOrCreate(
                ['application_id' => $this->application->id, 'subject_id' => $subject->id],
                [
                    'grade' => $this->grades[$subject->id] ?? null,
                    'source' => 'manual',
                    'confidence' => null,
                ]
            );
        }

        $this->refreshScore($scoringService);
        session()->flash('status', 'Draft prijave je uspješno sačuvan.');
    }

    public function submit()
    {
        $this->saveDraft();

        $this->application->refresh();
        $uploadedTypes = $this->application->documents()
            ->whereIn('type', array_keys(self::REQUIRED_DOCUMENT_TYPES))
            ->pluck('type')
            ->unique()
            ->all();

        $missingTypes = array_diff(array_keys(self::REQUIRED_DOCUMENT_TYPES), $uploadedTypes);
        if (! empty($missingTypes)) {
            $missingLabels = array_map(function ($type) {
                return self::REQUIRED_DOCUMENT_TYPES[$type] ?? $type;
            }, $missingTypes);

            session()->flash('error', 'Prije slanja morate uploadovati sve obavezne dokumente: '.implode(', ', $missingLabels).'.');
            return;
        }

        $this->application->update([
            'status' => 'Submitted',
            'submitted_at' => now(),
            'locked_at' => now(),
        ]);

        session()->flash('status', 'Prijava je uspješno poslana.');
    }

    public function processUploadedDocument($documentId)
    {
        $extractionService = app(GradeExtractionService::class);
        $scoringService = app(ScoringService::class);

        $document = $this->application->documents()->find($documentId);
        if (! $document || ! in_array($document->type, ['svjedodzba', 'diploma'], true)) {
            return;
        }

        $suggestions = $extractionService->extractFromDocument($this->application, $document);
        if (empty($suggestions)) {
            $this->application->update(['extraction_status' => 'failed']);
            session()->flash('error', 'OCR nije uspješno prepoznao ocjene. Unesite ih ručno.');
            return;
        }

        $needsReview = false;
        foreach ($suggestions as $subjectId => $data) {
            ApplicationGrade::updateOrCreate(
                ['application_id' => $this->application->id, 'subject_id' => $subjectId],
                $data
            );
            $this->grades[$subjectId] = $data['grade'];
            if ((float) $data['confidence'] < 60) {
                $needsReview = true;
            }
        }

        $this->application->update([
            'extraction_status' => $needsReview ? 'needs_review' : 'processed',
        ]);

        $this->refreshScore($scoringService);
        session()->flash('status', 'Ocjene su automatski predložene. Provjerite i korigujte prije slanja.');
    }

    public function render()
    {
        $faculties = Faculty::orderBy('name')->get();
        $selectedFaculty = $this->facultyId ? Faculty::find($this->facultyId) : null;
        $selectedDepartment = $this->departmentId ? Department::find($this->departmentId) : null;

        return view('livewire.admission-wizard', [
            'faculties' => $faculties,
            'selectedFaculty' => $selectedFaculty,
            'selectedDepartment' => $selectedDepartment,
        ]);
    }

    private function loadDepartments()
    {
        $this->departments = $this->facultyId
            ? Department::where('faculty_id', $this->facultyId)->orderBy('name')->get()
            : collect();
    }

    private function loadSubjects()
    {
        $this->subjects = $this->departmentId
            ? Department::find($this->departmentId)->subjects()->orderBy('name')->get()
            : collect();
    }

    private function loadCurrentGrades()
    {
        foreach ($this->application->grades as $grade) {
            $this->grades[$grade->subject_id] = $grade->grade;
        }
    }

    private function refreshScore(?ScoringService $scoringService = null)
    {
        $scoringService = $scoringService ?: app(ScoringService::class);
        $result = $scoringService->calculate($this->application->fresh());
        $this->breakdown = $result['breakdown'];
        $this->totalPoints = $result['total'];
        $this->application->update(['total_points' => $this->totalPoints]);
    }

    private function isEditable()
    {
        $this->application->refresh();
        return $this->application->isEditable();
    }
}
