<?php

namespace App\Http\Livewire;

use App\Models\Application;
use App\Models\Document;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

class DocumentUploader extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    public $application;
    public $documentFiles = [];

    public $requiredDocumentTypes = [
        'licna_karta' => 'Lična karta / pasoš',
        'svjedodzba' => 'Svjedodžba',
        'rodni_list' => 'Rodni list',
        'dokaz_o_uplati' => 'Dokaz o uplati',
    ];

    public function mount()
    {
        $this->application = Application::where('user_id', auth()->id())->firstOrFail();
    }

    public function uploadRequiredDocument($type)
    {
        $this->application->refresh();
        if (! $this->application->isEditable()) {
            session()->flash('error', 'Prijava je zaključana. Upload nije dozvoljen.');
            return;
        }

        $this->validate([
            'documentFiles.'.$type => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ], [], ['documentFiles.'.$type => $this->requiredDocumentTypes[$type] ?? 'dokument']);

        $file = $this->documentFiles[$type];
        $storedPath = $file->store('applications/'.$this->application->id, 'local');
        $document = Document::create([
            'application_id' => $this->application->id,
            'type' => $type,
            'path' => $storedPath,
            'original_name' => $file->getClientOriginalName(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);

        $this->documentFiles[$type] = null;
        $this->emit('documentUploaded', $document->id);
        $this->emit('refreshDocuments');
        session()->flash('status', 'Dokument "'.$this->requiredDocumentTypes[$type].'" je uspješno uploadovan.');
    }

    public function render()
    {
        $uploadedTypes = $this->application->documents()
            ->whereIn('type', array_keys($this->requiredDocumentTypes))
            ->pluck('type')
            ->unique()
            ->values()
            ->all();

        return view('livewire.document-uploader', [
            'uploadedTypes' => $uploadedTypes,
        ]);
    }
}
