<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Equipment;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\MaintenanceDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EquipmentMaintenanceDocumentsDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public Equipment $equipment;
    public MaintenanceDocument $maintenanceDocument;
    public $maintenanceDocumentDocumentFile;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New MaintenanceDocument';

    protected $rules = [
        'maintenanceDocument.document_name' => [
            'required',
            'max:255',
            'string',
        ],
        'maintenanceDocument.document_remarks' => [
            'nullable',
            'max:255',
            'string',
        ],
        'maintenanceDocumentDocumentFile' => ['file', 'required'],
    ];

    public function mount(Equipment $equipment)
    {
        $this->equipment = $equipment;
        $this->resetMaintenanceDocumentData();
    }

    public function resetMaintenanceDocumentData()
    {
        $this->maintenanceDocument = new MaintenanceDocument();

        $this->maintenanceDocumentDocumentFile = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newMaintenanceDocument()
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.equipment_maintenance_documents.new_title'
        );
        $this->resetMaintenanceDocumentData();

        $this->showModal();
    }

    public function editMaintenanceDocument(
        MaintenanceDocument $maintenanceDocument
    ) {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.equipment_maintenance_documents.edit_title'
        );
        $this->maintenanceDocument = $maintenanceDocument;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        if (!$this->maintenanceDocument->equipment_id) {
            $this->authorize('create', MaintenanceDocument::class);

            $this->maintenanceDocument->equipment_id = $this->equipment->id;
        } else {
            $this->authorize('update', $this->maintenanceDocument);
        }

        if ($this->maintenanceDocumentDocumentFile) {
            $this->maintenanceDocument->document_file = $this->maintenanceDocumentDocumentFile->store(
                'public'
            );
        }

        $this->maintenanceDocument->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', MaintenanceDocument::class);

        collect($this->selected)->each(function (string $id) {
            $maintenanceDocument = MaintenanceDocument::findOrFail($id);

            if ($maintenanceDocument->document_file) {
                Storage::delete($maintenanceDocument->document_file);
            }

            $maintenanceDocument->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetMaintenanceDocumentData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach (
            $this->equipment->maintenanceDocuments
            as $maintenanceDocument
        ) {
            array_push($this->selected, $maintenanceDocument->id);
        }
    }

    public function render()
    {
        return view('livewire.equipment-maintenance-documents-detail', [
            'maintenanceDocuments' => $this->equipment
                ->maintenanceDocuments()
                ->paginate(20),
        ]);
    }
}
