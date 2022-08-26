<?php

namespace App\Http\Controllers\Api;

use App\Models\SurveyPeriod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SurveyPeriodResource;
use App\Http\Resources\SurveyPeriodCollection;
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
            ->paginate();

        return new SurveyPeriodCollection($surveyPeriods);
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

        return new SurveyPeriodResource($surveyPeriod);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SurveyPeriod $surveyPeriod
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SurveyPeriod $surveyPeriod)
    {
        $this->authorize('view', $surveyPeriod);

        return new SurveyPeriodResource($surveyPeriod);
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

        return new SurveyPeriodResource($surveyPeriod);
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

        return response()->noContent();
    }
}
