<?php

namespace App\Http\Controllers\Api;

use App\Models\Survey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PhotoResource;
use App\Http\Resources\PhotoCollection;

class SurveyPhotosController extends Controller
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

        $photos = $survey
            ->photos()
            ->search($search)
            ->latest()
            ->paginate();

        return new PhotoCollection($photos);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey $survey
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Survey $survey)
    {
        $this->authorize('create', Photo::class);

        $validated = $request->validate([
            'photo' => ['nullable', 'file'],
            'remarks' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('public');
        }

        $photo = $survey->photos()->create($validated);

        return new PhotoResource($photo);
    }
}
