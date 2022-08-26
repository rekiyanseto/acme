<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SubArea;
use App\Models\Equipment;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SubAreaEquipmentsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public SubArea $subArea;
    public Equipment $equipment;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Equipment';

    protected $rules = [
        'equipment.equipment_name' => ['required', 'max:255', 'string'],
        'equipment.equipment_code' => [
            'required',
            'unique:equipment,equipment_code',
            'max:255',
            'string',
        ],
        'equipment.maintenance_by' => ['nullable', 'max:255', 'string'],
        'equipment.equipment_description' => ['nullable', 'max:255', 'string'],
    ];

    public function mount(SubArea $subArea)
    {
        $this->subArea = $subArea;
        $this->resetEquipmentData();
    }

    public function resetEquipmentData()
    {
        $this->equipment = new Equipment();

        $this->equipment->maintenance_by = 'Internal';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newEquipment()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.sub_area_equipments.new_title');
        $this->resetEquipmentData();

        $this->showModal();
    }

    public function editEquipment(Equipment $equipment)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.sub_area_equipments.edit_title');
        $this->equipment = $equipment;

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
        if (!$this->equipment->sub_area_id) {
            $this->validate();
        } else {
            $this->validate([
                'equipment.equipment_name' => ['required', 'max:255', 'string'],
                'equipment.equipment_code' => [
                    'required',
                    Rule::unique('equipment', 'equipment_code')->ignore(
                        $this->equipment
                    ),
                    'max:255',
                    'string',
                ],
                'equipment.maintenance_by' => ['nullable', 'max:255', 'string'],
                'equipment.equipment_description' => [
                    'nullable',
                    'max:255',
                    'string',
                ],
            ]);
        }

        if (!$this->equipment->sub_area_id) {
            $this->authorize('create', Equipment::class);

            $this->equipment->sub_area_id = $this->subArea->id;
        } else {
            $this->authorize('update', $this->equipment);
        }

        $this->equipment->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Equipment::class);

        Equipment::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetEquipmentData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->subArea->equipments as $equipment) {
            array_push($this->selected, $equipment->id);
        }
    }

    public function render()
    {
        return view('livewire.sub-area-equipments-detail', [
            'equipments' => $this->subArea->equipments()->paginate(20),
        ]);
    }
}
