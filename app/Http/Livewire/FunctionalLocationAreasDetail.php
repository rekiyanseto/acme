<?php

namespace App\Http\Livewire;

use App\Models\Area;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Models\FunctionalLocation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FunctionalLocationAreasDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public FunctionalLocation $functionalLocation;
    public Area $area;
    public $areaAreaSitePlan;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Area';

    protected $rules = [
        'area.area_code' => [
            'required',
            'unique:areas,area_code',
            'max:255',
            'string',
        ],
        'area.area_name' => ['required', 'max:255', 'string'],
        'areaAreaSitePlan' => ['nullable', 'mimes:jpg,jpeg,png'],
    ];

    public function mount(FunctionalLocation $functionalLocation)
    {
        $this->functionalLocation = $functionalLocation;
        $this->resetAreaData();
    }

    public function resetAreaData()
    {
        $this->area = new Area();

        $this->areaAreaSitePlan = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newArea()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.functional_location_areas.new_title');
        $this->resetAreaData();

        $this->showModal();
    }

    public function editArea(Area $area)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.functional_location_areas.edit_title');
        $this->area = $area;

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
        if (!$this->area->functional_location_id) {
            $this->validate();
        } else {
            $this->validate([
                'area.area_code' => [
                    'required',
                    Rule::unique('areas', 'area_code')->ignore($this->area),
                    'max:255',
                    'string',
                ],
                'area.area_name' => ['required', 'max:255', 'string'],
                'areaAreaSitePlan' => ['nullable', 'mimes:jpg,jpeg,png'],
            ]);
        }

        if (!$this->area->functional_location_id) {
            $this->authorize('create', Area::class);

            $this->area->functional_location_id = $this->functionalLocation->id;
        } else {
            $this->authorize('update', $this->area);
        }

        if ($this->areaAreaSitePlan) {
            $this->area->area_site_plan = $this->areaAreaSitePlan->store(
                'public'
            );
        }

        $this->area->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Area::class);

        collect($this->selected)->each(function (string $id) {
            $area = Area::findOrFail($id);

            if ($area->area_site_plan) {
                Storage::delete($area->area_site_plan);
            }

            $area->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetAreaData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->functionalLocation->areas as $area) {
            array_push($this->selected, $area->id);
        }
    }

    public function render()
    {
        return view('livewire.functional-location-areas-detail', [
            'areas' => $this->functionalLocation->areas()->paginate(20),
        ]);
    }
}
