<?php

namespace App\Http\Controllers\Api;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SurveyResource;
use App\Http\Resources\SurveyCollection;

class SubCategorySurveysController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubCategory $subCategory
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SubCategory $subCategory)
    {
        $this->authorize('view', $subCategory);

        $search = $request->get('search', '');

        $surveys = $subCategory
            ->surveys()
            ->search($search)
            ->latest()
            ->paginate();

        return new SurveyCollection($surveys);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubCategory $subCategory
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SubCategory $subCategory)
    {
        $this->authorize('create', Survey::class);

        $validated = $request->validate([
            'survey_period_id' => ['required', 'exists:survey_periods,id'],
        ]);

        $survey = $subCategory->surveys()->create($validated);

        return new SurveyResource($survey);
    }
}
