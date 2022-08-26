<?php

namespace App\Http\Controllers\Api;

use App\Models\SurveyPeriod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PhotoResource;
use App\Http\Resources\PhotoCollection;

class SurveyPeriodPhotosController extends Controller
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

        $photos = $surveyPeriod
            ->photos()
            ->search($search)
            ->latest()
            ->paginate();

        return new PhotoCollection($photos);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SurveyPeriod $surveyPeriod
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SurveyPeriod $surveyPeriod)
    {
        $this->authorize('create', Photo::class);

        $validated = $request->validate([
            'photo' => ['nullable', 'mimes:png,jpg,jpeg'],
            'remarks' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('public');
        }

        $photo = $surveyPeriod->photos()->create($validated);

        return new PhotoResource($photo);
    }
}
