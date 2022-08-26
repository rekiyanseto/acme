<?php

namespace App\Http\Controllers\Api;

use App\Models\SurveyPeriod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SurveyResource;
use App\Http\Resources\SurveyCollection;

class SurveyPeriodSurveysController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SurveyPeriod $surveyPeriod
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SurveyPeriod $surveyPeriod)
    {
        $this->authorize('view', $surveyPeriod);

        $search = $request->get('search', '');

        $surveys = $surveyPeriod
            ->surveys()
            ->search($search)
            ->latest()
            ->paginate();

        return new SurveyCollection($surveys);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SurveyPeriod $surveyPeriod
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SurveyPeriod $surveyPeriod)
    {
        $this->authorize('create', Survey::class);

        $validated = $request->validate([
            'sub_category_id' => ['required', 'exists:sub_categories,id'],
        ]);

        $survey = $surveyPeriod->surveys()->create($validated);

        return new SurveyResource($survey);
    }
}
