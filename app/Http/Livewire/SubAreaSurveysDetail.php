<?php

namespace App\Http\Livewire;

use App\Models\Survey;
use Livewire\Component;
use App\Models\SubArea;
use App\Models\SubCategory;
use Livewire\WithPagination;
use App\Models\SurveyPeriod;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SubAreaSurveysDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public SubArea $subArea;
    public Survey $survey;
    public $surveyPeriodsForSelect = [];
    public $subCategoriesForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Survey';

    protected $rules = [
        'survey.survey_period_id' => ['required', 'exists:survey_periods,id'],
        'survey.sub_category_id' => ['required', 'exists:sub_categories,id'],
    ];

    public function mount(SubArea $subArea)
    {
        $this->subArea = $subArea;
        $this->surveyPeriodsForSelect = SurveyPeriod::where('periode_status', 'Active')->pluck(
            'periode_name',
            'id'
        );
        $this->subCategoriesForSelect = SubCategory::pluck(
            'category_name',
            'id'
        );
        $this->resetSurveyData();
    }

    public function resetSurveyData()
    {
        $this->survey = new Survey();

        $this->survey->survey_period_id = null;
        $this->survey->sub_category_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newSurvey()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.sub_area_surveys.new_title');
        $this->resetSurveyData();

        $this->showModal();
    }

    public function editSurvey(Survey $survey)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.sub_area_surveys.edit_title');
        $this->survey = $survey;

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

        if (!$this->survey->sub_area_id) {
            $this->authorize('create', Survey::class);

            $this->survey->sub_area_id = $this->subArea->id;
        } else {
            $this->authorize('update', $this->survey);
        }

        $this->survey->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Survey::class);

        Survey::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetSurveyData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->subArea->surveys as $survey) {
            array_push($this->selected, $survey->id);
        }
    }

    public function render()
    {
        return view('livewire.sub-area-surveys-detail', [
            'surveys' => $this->subArea->surveys()->with('settlementByBusinessUnits')->with('surveyResults')->orderBy('id', 'desc')->paginate(5),
        ]);
    }
}
