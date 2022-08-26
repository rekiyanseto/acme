<?php

namespace App\Http\Livewire;

use App\Models\Area;
use Livewire\Component;
use App\Models\SubArea;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AreaSubAreasDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public Area $area;
    public SubArea $subArea;
    public $subAreaSubAreaSitePlan;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New SubArea';

    protected $rules = [
        'subArea.sub_area_code' => [
            'required',
            'unique:sub_areas,sub_area_code',
            'max:255',
            'string',
        ],
        'subArea.sub_area_name' => ['required', 'max:255', 'string'],
        'subArea.maintenance_by' => ['nullable', 'max:255', 'string'],
        'subArea.sub_area_description' => ['nullable', 'max:255', 'string'],
        'subAreaSubAreaSitePlan' => ['nullable', 'mimes:jpg,jpeg,png'],
    ];

    public function mount(Area $area)
    {
        $this->area = $area;
        $this->resetSubAreaData();
    }

    public function resetSubAreaData()
    {
        $this->subArea = new SubArea();

        $this->subAreaSubAreaSitePlan = null;
        $this->subArea->maintenance_by = 'Internal';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newSubArea()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.area_sub_areas.new_title');
        $this->resetSubAreaData();

        $this->showModal();
    }

    public function editSubArea(SubArea $subArea)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.area_sub_areas.edit_title');
        $this->subArea = $subArea;

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
        if (!$this->subArea->area_id) {
            $this->validate();
        } else {
            $this->validate([
                'subArea.sub_area_code' => [
                    'required',
                    Rule::unique('sub_areas', 'sub_area_code')->ignore(
                        $this->subArea
                    ),
                    'max:255',
                    'string',
                ],
                'subArea.sub_area_name' => ['required', 'max:255', 'string'],
                'subArea.maintenance_by' => ['nullable', 'max:255', 'string'],
                'subArea.sub_area_description' => [
                    'nullable',
                    'max:255',
                    'string',
                ],
                'subAreaSubAreaSitePlan' => ['nullable', 'mimes:jpg,jpeg,png'],
            ]);
        }

        if (!$this->subArea->area_id) {
            $this->authorize('create', SubArea::class);

            $this->subArea->area_id = $this->area->id;
        } else {
            $this->authorize('update', $this->subArea);
        }

        if ($this->subAreaSubAreaSitePlan) {
            $this->subArea->sub_area_site_plan = $this->subAreaSubAreaSitePlan->store(
                'public'
            );
        }

        $this->subArea->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', SubArea::class);

        collect($this->selected)->each(function (string $id) {
            $subArea = SubArea::findOrFail($id);

            if ($subArea->sub_area_site_plan) {
                Storage::delete($subArea->sub_area_site_plan);
            }

            $subArea->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetSubAreaData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->area->subAreas as $subArea) {
            array_push($this->selected, $subArea->id);
        }
    }

    public function render()
    {
        return view('livewire.area-sub-areas-detail', [
            'subAreas' => $this->area->subAreas()->paginate(20),
        ]);
    }
}
