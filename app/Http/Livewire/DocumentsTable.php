<?php

namespace App\Http\Livewire;

use App\Models\Application;
use Livewire\Component;

class DocumentsTable extends Component
{
    public $application;

    protected $listeners = ['refreshDocuments' => '$refresh'];

    public function mount()
    {
        $this->application = Application::where('user_id', auth()->id())->first();
    }

    public function render()
    {
        $documents = $this->application
            ? $this->application->documents()->latest()->get()
            : collect();

        return view('livewire.documents-table', compact('documents'));
    }
}
