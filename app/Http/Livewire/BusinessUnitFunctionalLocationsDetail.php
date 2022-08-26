<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BusinessUnit;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Models\FunctionalLocation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BusinessUnitFunctionalLocationsDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public BusinessUnit $businessUnit;
    public FunctionalLocation $functionalLocation;
    public $functionalLocationFunctionalLocationSitePlan;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New FunctionalLocation';

    protected $rules = [
        'functionalLocation.functional_location_code' => [
            'required',
            'unique:functional_locations,functional_location_code',
            'max:255',
            'string',
        ],
        'functionalLocation.functional_location_name' => [
            'required',
            'max:255',
            'string',
        ],
        'functionalLocationFunctionalLocationSitePlan' => [
            'nullable',
            'mimes:jpg,jpeg,png',
        ],
    ];

    public function mount(BusinessUnit $businessUnit)
    {
        $this->businessUnit = $businessUnit;
        $this->resetFunctionalLocationData();
    }

    public function resetFunctionalLocationData()
    {
        $this->functionalLocation = new FunctionalLocation();

        $this->functionalLocationFunctionalLocationSitePlan = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newFunctionalLocation()
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.business_unit_functional_locations.new_title'
        );
        $this->resetFunctionalLocationData();

        $this->showModal();
    }

    public function editFunctionalLocation(
        FunctionalLocation $functionalLocation
    ) {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.business_unit_functional_locations.edit_title'
        );
        $this->functionalLocation = $functionalLocation;

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
        if (!$this->functionalLocation->business_unit_id) {
            $this->validate();
        } else {
            $this->validate([
                'functionalLocation.functional_location_code' => [
                    'required',
                    Rule::unique(
                        'functional_locations',
                        'functional_location_code'
                    )->ignore($this->functionalLocation),
                    'max:255',
                    'string',
                ],
                'functionalLocation.functional_location_name' => [
                    'required',
                    'max:255',
                    'string',
                ],
                'functionalLocationFunctionalLocationSitePlan' => [
                    'nullable',
                    'mimes:jpg,jpeg,png',
                ],
            ]);
        }

        if (!$this->functionalLocation->business_unit_id) {
            $this->authorize('create', FunctionalLocation::class);

            $this->functionalLocation->business_unit_id =
                $this->businessUnit->id;
        } else {
            $this->authorize('update', $this->functionalLocation);
        }

        if ($this->functionalLocationFunctionalLocationSitePlan) {
            $this->functionalLocation->functional_location_site_plan = $this->functionalLocationFunctionalLocationSitePlan->store(
                'public'
            );
        }

        $this->functionalLocation->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', FunctionalLocation::class);

        collect($this->selected)->each(function (string $id) {
            $functionalLocation = FunctionalLocation::findOrFail($id);

            if ($functionalLocation->functional_location_site_plan) {
                Storage::delete(
                    $functionalLocation->functional_location_site_plan
                );
            }

            $functionalLocation->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetFunctionalLocationData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach (
            $this->businessUnit->functionalLocations
            as $functionalLocation
        ) {
            array_push($this->selected, $functionalLocation->id);
        }
    }

    public function render()
    {
        return view('livewire.business-unit-functional-locations-detail', [
            'functionalLocations' => $this->businessUnit
                ->functionalLocations()
                ->paginate(20),
        ]);
    }
}
