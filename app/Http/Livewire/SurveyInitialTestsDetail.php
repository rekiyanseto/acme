<?php

namespace App\Http\Livewire;

use App\Models\Survey;
use Livewire\Component;
use App\Models\InitialTest;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SurveyInitialTestsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Survey $survey;
    public InitialTest $initialTest;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New InitialTest';

    protected $rules = [
        'initialTest.initial_test_tool' => ['required', 'max:255', 'string'],
        'initialTest.initial_test_result' => ['required', 'max:255', 'string'],
        'initialTest.initial_test_standard' => [
            'required',
            'max:255',
            'string',
        ],
        'initialTest.initial_test_note' => ['nullable', 'max:255', 'string'],
    ];

    public function mount(Survey $survey)
    {
        $this->survey = $survey;
        $this->resetInitialTestData();
    }

    public function resetInitialTestData()
    {
        $this->initialTest = new InitialTest();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newInitialTest()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.survey_initial_tests.new_title');
        $this->resetInitialTestData();

        $this->showModal();
    }

    public function editInitialTest(InitialTest $initialTest)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.survey_initial_tests.edit_title');
        $this->initialTest = $initialTest;

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

        if (!$this->initialTest->survey_id) {
            $this->authorize('create', InitialTest::class);

            $this->initialTest->survey_id = $this->survey->id;
        } else {
            $this->authorize('update', $this->initialTest);
        }

        $this->initialTest->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', InitialTest::class);

        InitialTest::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetInitialTestData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->survey->initialTests as $initialTest) {
            array_push($this->selected, $initialTest->id);
        }
    }

    public function render()
    {
        return view('livewire.survey-initial-tests-detail', [
            'initialTests' => $this->survey->initialTests()->orderBy('id', 'desc')->paginate(5),
        ]);
    }
}
