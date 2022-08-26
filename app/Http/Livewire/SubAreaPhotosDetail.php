<?php

namespace App\Http\Livewire;

use App\Models\Photo;
use Livewire\Component;
use App\Models\SubArea;
use Livewire\WithPagination;
use App\Models\SurveyPeriod;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SubAreaPhotosDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public SubArea $subArea;
    public Photo $photo;
    public $surveyPeriodsForSelect = [];
    public $photoPhoto;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Photo';

    protected $rules = [
        'photo.survey_period_id' => ['required', 'exists:survey_periods,id'],
        'photoPhoto' => ['nullable', 'mimes:png,jpg,jpeg'],
        'photo.remarks' => ['nullable', 'max:255', 'string'],
    ];

    public function mount(SubArea $subArea)
    {
        $this->subArea = $subArea;
        $this->surveyPeriodsForSelect = SurveyPeriod::where('periode_status', 'Active')->pluck(
            'periode_name',
            'id'
        );
        $this->resetPhotoData();
    }

    public function resetPhotoData()
    {
        $this->photo = new Photo();

        $this->photoPhoto = null;
        $this->photo->survey_period_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newPhoto()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.sub_area_photos.new_title');
        $this->resetPhotoData();

        $this->showModal();
    }

    public function editPhoto(Photo $photo)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.sub_area_photos.edit_title');
        $this->photo = $photo;

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

        if (!$this->photo->sub_area_id) {
            $this->authorize('create', Photo::class);

            $this->photo->sub_area_id = $this->subArea->id;
        } else {
            $this->authorize('update', $this->photo);
        }

        if ($this->photoPhoto) {
            $this->photo->photo = $this->photoPhoto->store('public');
        }

        $this->photo->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Photo::class);

        collect($this->selected)->each(function (string $id) {
            $photo = Photo::findOrFail($id);

            if ($photo->photo) {
                Storage::delete($photo->photo);
            }

            $photo->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetPhotoData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->subArea->photos as $photo) {
            array_push($this->selected, $photo->id);
        }
    }

    public function render()
    {
        return view('livewire.sub-area-photos-detail', [
            'photos' => $this->subArea->photos()->paginate(20),
        ]);
    }
}
