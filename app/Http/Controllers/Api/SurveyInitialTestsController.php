<?php

namespace App\Http\Controllers\Api;

use App\Models\Survey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InitialTestResource;
use App\Http\Resources\InitialTestCollection;

class SurveyInitialTestsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey $survey
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Survey $survey)
    {
        $this->authorize('view', $survey);

        $search = $request->get('search', '');

        $initialTests = $survey
            ->initialTests()
            ->search($search)
            ->latest()
            ->paginate();

        return new InitialTestCollection($initialTests);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey $survey
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Survey $survey)
    {
        $this->authorize('create', InitialTest::class);

        $validated = $request->validate([
            'initial_test_tool' => ['required', 'max:255', 'string'],
            'initial_test_result' => ['required', 'max:255', 'string'],
            'initial_test_standard' => ['required', 'max:255', 'string'],
            'initial_test_note' => ['nullable', 'max:255', 'string'],
        ]);

        $initialTest = $survey->initialTests()->create($validated);

        return new InitialTestResource($initialTest);
    }
}
