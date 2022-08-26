<?php

namespace App\Http\Controllers\Api;

use App\Models\Survey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SurveyResource;
use App\Http\Resources\SurveyCollection;
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
            ->paginate();

        return new SurveyCollection($surveys);
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

        return new SurveyResource($survey);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Survey $survey)
    {
        $this->authorize('view', $survey);

        return new SurveyResource($survey);
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

        return new SurveyResource($survey);
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

        return response()->noContent();
    }
}
