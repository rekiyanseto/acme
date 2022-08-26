<?php

namespace App\Http\Livewire;

use App\Models\Photo;
use App\Models\Survey;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SurveyPhotosDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public Survey $survey;
    public Photo $photo;
    public $photoPhoto;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Photo';

    protected $rules = [
        'photoPhoto' => ['nullable', 'mimes:jpg,jpeg,png'],
        'photo.remarks' => ['nullable', 'max:255', 'string'],
    ];

    public function mount(Survey $survey)
    {
        $this->survey = $survey;
        $this->resetPhotoData();
    }

    public function resetPhotoData()
    {
        $this->photo = new Photo();

        $this->photoPhoto = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newPhoto()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.survey_photos.new_title');
        $this->resetPhotoData();

        $this->showModal();
    }

    public function editPhoto(Photo $photo)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.survey_photos.edit_title');
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

        if (!$this->photo->survey_id) {
            $this->authorize('create', Photo::class);

            $this->photo->survey_id = $this->survey->id;
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

        foreach ($this->survey->photos as $photo) {
            array_push($this->selected, $photo->id);
        }
    }

    public function render()
    {
        return view('livewire.survey-photos-detail', [
            'photos' => $this->survey->photos()->orderBy('id', 'desc')->paginate(10),
        ]);
    }
}
