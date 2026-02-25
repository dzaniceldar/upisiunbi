<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    private const REQUIRED_DOCUMENT_TYPES = [
        'licna_karta' => 'Lična karta / pasoš',
        'svjedodzba' => 'Svjedodžba',
        'rodni_list' => 'Rodni list',
        'dokaz_o_uplati' => 'Dokaz o uplati',
    ];

    public function index()
    {
        $application = Application::with('documents')->where('user_id', auth()->id())->first();
        $uploadedTypes = $application
            ? $application->documents->pluck('type')->unique()->values()->all()
            : [];

        return view('applications.documents', [
            'application' => $application,
            'requiredDocumentTypes' => self::REQUIRED_DOCUMENT_TYPES,
            'uploadedTypes' => $uploadedTypes,
        ]);
    }

    public function uploadRequired(Request $request)
    {
        $application = Application::where('user_id', auth()->id())->firstOrFail();
        if (! $application->isEditable()) {
            return back()->with('error', 'Prijava je zaključana. Upload nije dozvoljen.');
        }

        $validated = $request->validate([
            'type' => 'required|in:'.implode(',', array_keys(self::REQUIRED_DOCUMENT_TYPES)),
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ], [], ['file' => 'dokument']);

        $existing = $application->documents()->where('type', $validated['type'])->latest()->first();
        if ($existing) {
            Storage::disk('local')->delete($existing->path);
            $existing->delete();
        }

        $uploadedFile = $request->file('file');
        $storedPath = $uploadedFile->store('applications/'.$application->id, 'local');

        Document::create([
            'application_id' => $application->id,
            'type' => $validated['type'],
            'path' => $storedPath,
            'original_name' => $uploadedFile->getClientOriginalName(),
            'mime' => $uploadedFile->getClientMimeType(),
            'size' => $uploadedFile->getSize(),
        ]);

        $label = self::REQUIRED_DOCUMENT_TYPES[$validated['type']] ?? 'Dokument';
        return back()->with('status', $label.' je uspješno uploadovan.');
    }

    public function download(Document $document)
    {
        $this->authorize('view', $document);

        return Storage::download($document->path, $document->original_name);
    }
}
