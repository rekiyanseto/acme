<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SubArea;
use App\Models\Equipment;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\SurveyPeriod;
use App\Http\Requests\SurveyStoreRequest;
use App\Http\Requests\SurveyUpdateRequest;

class SurveyController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Survey::class);

        $search = $request->get('search', '');

        $surveys = Survey::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.surveys.index', compact('surveys', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Survey::class);

        $surveyPeriods = SurveyPeriod::where('periode_status', 'Active')->pluck('periode_name', 'id');
        $subCategories = SubCategory::pluck('category_name', 'id');
        $subAreas = SubArea::pluck('sub_area_name', 'id');
        $equipments = Equipment::pluck('equipment_name', 'id');

        return view(
            'app.surveys.create',
            compact('surveyPeriods', 'subCategories', 'subAreas', 'equipments')
        );
    }

    /**
     * @param \App\Http\Requests\SurveyStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SurveyStoreRequest $request)
    {
        $this->authorize('create', Survey::class);

        $validated = $request->validated();

        $survey = Survey::create($validated);

        return redirect()
            ->route('surveys.edit', $survey)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Survey $survey)
    {
        $this->authorize('view', $survey);

        return view('app.surveys.show', compact('survey'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Survey $survey)
    {
        $this->authorize('update', $survey);

        $surveyPeriods = SurveyPeriod::where('periode_status', 'Active')->pluck('periode_name', 'id');
        $subCategories = SubCategory::pluck('category_name', 'id');
        $subAreas = SubArea::pluck('sub_area_name', 'id');
        $equipments = Equipment::pluck('equipment_name', 'id');

        return view(
            'app.surveys.edit',
            compact(
                'survey',
                'surveyPeriods',
                'subCategories',
                'subAreas',
                'equipments'
            )
        );
    }

    /**
     * @param \App\Http\Requests\SurveyUpdateRequest $request
     * @param \App\Models\Survey $survey
     * @return \Illuminate\Http\Response
     */
    public function update(SurveyUpdateRequest $request, Survey $survey)
    {
        $this->authorize('update', $survey);

        $validated = $request->validated();

        $survey->update($validated);

        return redirect()
            ->route('surveys.edit', $survey)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Survey $survey)
    {
        $this->authorize('delete', $survey);

        $survey->delete();

        return redirect()
            ->route('surveys.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
