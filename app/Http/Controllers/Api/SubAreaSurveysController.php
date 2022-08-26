<?php

namespace App\Http\Controllers\Api;

use App\Models\SubArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SurveyResource;
use App\Http\Resources\SurveyCollection;

class SubAreaSurveysController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubArea $subArea
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SubArea $subArea)
    {
        $this->authorize('view', $subArea);

        $search = $request->get('search', '');

        $surveys = $subArea
            ->surveys()
            ->search($search)
            ->latest()
            ->paginate();

        return new SurveyCollection($surveys);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubArea $subArea
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SubArea $subArea)
    {
        $this->authorize('create', Survey::class);

        $validated = $request->validate([
            'survey_period_id' => ['required', 'exists:survey_periods,id'],
            'sub_category_id' => ['required', 'exists:sub_categories,id'],
        ]);

        $survey = $subArea->surveys()->create($validated);

        return new SurveyResource($survey);
    }
}
