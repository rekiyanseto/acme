<?php

namespace App\Http\Livewire;

use App\Models\Survey;
use Livewire\Component;
use App\Models\Settlement;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SurveySettlementsDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public Survey $survey;
    public Settlement $settlement;
    public $settlementSettlementDocument;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Settlement';

    protected $rules = [
        'settlement.settlement_note' => ['required', 'max:255', 'string'],
        'settlementSettlementDocument' => ['nullable', 'file'],
        'settlement.settlement_condition' => ['required', 'max:255', 'string'],
    ];

    public function mount(Survey $survey)
    {
        $this->survey = $survey;
        $this->resetSettlementData();
    }

    public function resetSettlementData()
    {
        $this->settlement = new Settlement();

        $this->settlementSettlementDocument = null;
        $this->settlement->settlement_condition = 'Oke Running Well';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newSettlement()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.survey_settlements.new_title');
        $this->resetSettlementData();

        $this->showModal();
    }

    public function editSettlement(Settlement $settlement)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.survey_settlements.edit_title');
        $this->settlement = $settlement;

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

        if (!$this->settlement->survey_id) {
            $this->authorize('create', Settlement::class);

            $this->settlement->survey_id = $this->survey->id;
        } else {
            $this->authorize('update', $this->settlement);
        }

        if ($this->settlementSettlementDocument) {
            $this->settlement->settlement_document = $this->settlementSettlementDocument->store(
                'public'
            );
        }

        $this->settlement->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Settlement::class);

        collect($this->selected)->each(function (string $id) {
            $settlement = Settlement::findOrFail($id);

            if ($settlement->settlement_document) {
                Storage::delete($settlement->settlement_document);
            }

            $settlement->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetSettlementData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->survey->settlements as $settlement) {
            array_push($this->selected, $settlement->id);
        }
    }

    public function render()
    {
        return view('livewire.survey-settlements-detail', [
            'settlements' => $this->survey->settlements()->orderBy('id', 'desc')->paginate(5),
        ]);
    }
}
