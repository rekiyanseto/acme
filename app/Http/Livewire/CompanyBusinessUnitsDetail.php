<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Company;
use Livewire\WithPagination;
use App\Models\BusinessUnit;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CompanyBusinessUnitsDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public Company $company;
    public BusinessUnit $businessUnit;
    public $businessUnitBusinessUnitSitePlan;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New BusinessUnit';

    protected $rules = [
        'businessUnit.business_unit_code' => [
            'required',
            'unique:business_units,business_unit_code',
            'max:255',
            'string',
        ],
        'businessUnit.business_unit_name' => ['required', 'max:255', 'string'],
        'businessUnitBusinessUnitSitePlan' => [
            'nullable',
            'mimes:jpg,jpeg,png',
        ],
    ];

    public function mount(Company $company)
    {
        $this->company = $company;
        $this->resetBusinessUnitData();
    }

    public function resetBusinessUnitData()
    {
        $this->businessUnit = new BusinessUnit();

        $this->businessUnitBusinessUnitSitePlan = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newBusinessUnit()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.company_business_units.new_title');
        $this->resetBusinessUnitData();

        $this->showModal();
    }

    public function editBusinessUnit(BusinessUnit $businessUnit)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.company_business_units.edit_title');
        $this->businessUnit = $businessUnit;

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
        if (!$this->businessUnit->company_id) {
            $this->validate();
        } else {
            $this->validate([
                'businessUnit.business_unit_code' => [
                    'required',
                    Rule::unique(
                        'business_units',
                        'business_unit_code'
                    )->ignore($this->businessUnit),
                    'max:255',
                    'string',
                ],
                'businessUnit.business_unit_name' => [
                    'required',
                    'max:255',
                    'string',
                ],
                'businessUnitBusinessUnitSitePlan' => [
                    'nullable',
                    'mimes:jpg,jpeg,png',
                ],
            ]);
        }

        if (!$this->businessUnit->company_id) {
            $this->authorize('create', BusinessUnit::class);

            $this->businessUnit->company_id = $this->company->id;
        } else {
            $this->authorize('update', $this->businessUnit);
        }

        if ($this->businessUnitBusinessUnitSitePlan) {
            $this->businessUnit->business_unit_site_plan = $this->businessUnitBusinessUnitSitePlan->store(
                'public'
            );
        }

        $this->businessUnit->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', BusinessUnit::class);

        collect($this->selected)->each(function (string $id) {
            $businessUnit = BusinessUnit::findOrFail($id);

            if ($businessUnit->business_unit_site_plan) {
                Storage::delete($businessUnit->business_unit_site_plan);
            }

            $businessUnit->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetBusinessUnitData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->company->businessUnits as $businessUnit) {
            array_push($this->selected, $businessUnit->id);
        }
    }

    public function render()
    {
        return view('livewire.company-business-units-detail', [
            'businessUnits' => $this->company->businessUnits()->paginate(20),
        ]);
    }
}
