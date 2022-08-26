<?php

namespace App\Http\Controllers\Api;

use App\Models\Survey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SurveyResultResource;
use App\Http\Resources\SurveyResultCollection;

class SurveySurveyResultsController extends Controller
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

        $surveyResults = $survey
            ->surveyResults()
            ->search($search)
            ->latest()
            ->paginate();

        return new SurveyResultCollection($surveyResults);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey $survey
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Survey $survey)
    {
        $this->authorize('create', SurveyResult::class);

        $validated = $request->validate([
            'survey_result_condition' => ['required', 'max:255', 'string'],
            'survey_result_note' => ['nullable', 'max:255', 'string'],
        ]);

        $surveyResult = $survey->surveyResults()->create($validated);

        return new SurveyResultResource($surveyResult);
    }
}
