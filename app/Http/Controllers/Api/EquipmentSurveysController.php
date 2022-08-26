<?php

namespace App\Http\Controllers\Api;

use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SurveyResource;
use App\Http\Resources\SurveyCollection;

class EquipmentSurveysController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Equipment $equipment
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Equipment $equipment)
    {
        $this->authorize('view', $equipment);

        $search = $request->get('search', '');

        $surveys = $equipment
            ->surveys()
            ->search($search)
            ->latest()
            ->paginate();

        return new SurveyCollection($surveys);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Equipment $equipment
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Equipment $equipment)
    {
        $this->authorize('create', Survey::class);

        $validated = $request->validate([
            'survey_period_id' => ['required', 'exists:survey_periods,id'],
            'sub_category_id' => ['required', 'exists:sub_categories,id'],
        ]);

        $survey = $equipment->surveys()->create($validated);

        return new SurveyResource($survey);
    }
}
