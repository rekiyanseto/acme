<?php

namespace App\Http\Livewire;

use App\Models\Survey;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SurveyResult;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SurveySurveyResultsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Survey $survey;
    public SurveyResult $surveyResult;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New SurveyResult';

    protected $rules = [
        'surveyResult.survey_result_condition' => [
            'required',
            'max:255',
            'string',
        ],
        'surveyResult.survey_result_note' => ['nullable', 'max:255', 'string'],
    ];

    public function mount(Survey $survey)
    {
        $this->survey = $survey;
        $this->resetSurveyResultData();
    }

    public function resetSurveyResultData()
    {
        $this->surveyResult = new SurveyResult();

        $this->surveyResult->survey_result_condition = 'Oke Running Well';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newSurveyResult()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.survey_survey_results.new_title');
        $this->resetSurveyResultData();

        $this->showModal();
    }

    public function editSurveyResult(SurveyResult $surveyResult)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.survey_survey_results.edit_title');
        $this->surveyResult = $surveyResult;

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

        if (!$this->surveyResult->survey_id) {
            $this->authorize('create', SurveyResult::class);

            $this->surveyResult->survey_id = $this->survey->id;
        } else {
            $this->authorize('update', $this->surveyResult);
        }

        $this->surveyResult->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', SurveyResult::class);

        SurveyResult::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetSurveyResultData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->survey->surveyResults as $surveyResult) {
            array_push($this->selected, $surveyResult->id);
        }
    }

    public function render()
    {
        return view('livewire.survey-survey-results-detail', [
            'surveyResults' => $this->survey->surveyResults()->orderBy('id', 'desc')->paginate(5),
        ]);
    }
}
