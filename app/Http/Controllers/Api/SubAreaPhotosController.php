<?php

namespace App\Http\Controllers\Api;

use App\Models\SubArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PhotoResource;
use App\Http\Resources\PhotoCollection;

class SubAreaPhotosController extends Controller
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

        $photos = $subArea
            ->photos()
            ->search($search)
            ->latest()
            ->paginate();

        return new PhotoCollection($photos);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubArea $subArea
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SubArea $subArea)
    {
        $this->authorize('create', Photo::class);

        $validated = $request->validate([
            'survey_period_id' => ['required', 'exists:survey_periods,id'],
            'photo' => ['nullable', 'mimes:png,jpg,jpeg'],
            'remarks' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('public');
        }

        $photo = $subArea->photos()->create($validated);

        return new PhotoResource($photo);
    }
}
