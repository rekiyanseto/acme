<?php

namespace App\Http\Livewire;

use App\Models\Survey;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\SettlementByBusinessUnit;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SurveySettlementByBusinessUnitsDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public Survey $survey;
    public SettlementByBusinessUnit $settlementByBusinessUnit;
    public $settlementByBusinessUnitPhoto;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New SettlementByBusinessUnit';

    protected $rules = [
        'settlementByBusinessUnit.spk_no' => ['required', 'max:255', 'string'],
        'settlementByBusinessUnit.progress' => ['required', 'numeric'],
        'settlementByBusinessUnitPhoto' => ['nullable', 'mimes:jpg,jpeg,png'],
        'settlementByBusinessUnit.condition' => [
            'required',
            'max:255',
            'string',
        ],
        'settlementByBusinessUnit.note' => ['nullable', 'max:255', 'string'],
    ];

    public function mount(Survey $survey)
    {
        $this->survey = $survey;
        $this->resetSettlementByBusinessUnitData();
    }

    public function resetSettlementByBusinessUnitData()
    {
        $this->settlementByBusinessUnit = new SettlementByBusinessUnit();

        $this->settlementByBusinessUnitPhoto = null;
        $this->settlementByBusinessUnit->condition = 'Oke Running Well';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newSettlementByBusinessUnit()
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.survey_settlement_by_business_units.new_title'
        );
        $this->resetSettlementByBusinessUnitData();

        $this->showModal();
    }

    public function editSettlementByBusinessUnit(
        SettlementByBusinessUnit $settlementByBusinessUnit
    ) {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.survey_settlement_by_business_units.edit_title'
        );
        $this->settlementByBusinessUnit = $settlementByBusinessUnit;

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

        if (!$this->settlementByBusinessUnit->survey_id) {
            $this->authorize('create', SettlementByBusinessUnit::class);

            $this->settlementByBusinessUnit->survey_id = $this->survey->id;
        } else {
            $this->authorize('update', $this->settlementByBusinessUnit);
        }

        if ($this->settlementByBusinessUnitPhoto) {
            $this->settlementByBusinessUnit->photo = $this->settlementByBusinessUnitPhoto->store(
                'public'
            );
        }

        $this->settlementByBusinessUnit->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', SettlementByBusinessUnit::class);

        collect($this->selected)->each(function (string $id) {
            $settlementByBusinessUnit = SettlementByBusinessUnit::findOrFail(
                $id
            );

            if ($settlementByBusinessUnit->photo) {
                Storage::delete($settlementByBusinessUnit->photo);
            }

            $settlementByBusinessUnit->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetSettlementByBusinessUnitData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach (
            $this->survey->settlementByBusinessUnits
            as $settlementByBusinessUnit
        ) {
            array_push($this->selected, $settlementByBusinessUnit->id);
        }
    }

    public function render()
    {
        return view('livewire.survey-settlement-by-business-units-detail', [
            'settlementByBusinessUnits' => $this->survey
                ->settlementByBusinessUnits()
                ->orderBy('id', 'desc')
                ->paginate(5),
        ]);
    }
}
