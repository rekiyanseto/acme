<?php

namespace App\Http\Controllers;

use App\Models\SurveyPeriod;
use Illuminate\Http\Request;
use App\Http\Requests\SurveyPeriodStoreRequest;
use App\Http\Requests\SurveyPeriodUpdateRequest;

class SurveyPeriodController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', SurveyPeriod::class);

        $search = $request->get('search', '');

        $surveyPeriods = SurveyPeriod::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.survey_periods.index',
            compact('surveyPeriods', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', SurveyPeriod::class);

        return view('app.survey_periods.create');
    }

    /**
     * @param \App\Http\Requests\SurveyPeriodStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SurveyPeriodStoreRequest $request)
    {
        $this->authorize('create', SurveyPeriod::class);

        $validated = $request->validated();

        $surveyPeriod = SurveyPeriod::create($validated);

        return redirect()
            ->route('survey-periods.edit', $surveyPeriod)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SurveyPeriod $surveyPeriod
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SurveyPeriod $surveyPeriod)
    {
        $this->authorize('view', $surveyPeriod);

        return view('app.survey_periods.show', compact('surveyPeriod'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SurveyPeriod $surveyPeriod
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SurveyPeriod $surveyPeriod)
    {
        $this->authorize('update', $surveyPeriod);

        return view('app.survey_periods.edit', compact('surveyPeriod'));
    }

    /**
     * @param \App\Http\Requests\SurveyPeriodUpdateRequest $request
     * @param \App\Models\SurveyPeriod $surveyPeriod
     * @return \Illuminate\Http\Response
     */
    public function update(
        SurveyPeriodUpdateRequest $request,
        SurveyPeriod $surveyPeriod
    ) {
        $this->authorize('update', $surveyPeriod);

        $validated = $request->validated();

        $surveyPeriod->update($validated);

        return redirect()
            ->route('survey-periods.edit', $surveyPeriod)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SurveyPeriod $surveyPeriod
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SurveyPeriod $surveyPeriod)
    {
        $this->authorize('delete', $surveyPeriod);

        $surveyPeriod->delete();

        return redirect()
            ->route('survey-periods.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
