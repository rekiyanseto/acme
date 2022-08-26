<?php

namespace App\Http\Controllers\Api;

use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PhotoResource;
use App\Http\Resources\PhotoCollection;

class EquipmentPhotosController extends Controller
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

        $photos = $equipment
            ->photos()
            ->search($search)
            ->latest()
            ->paginate();

        return new PhotoCollection($photos);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Equipment $equipment
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Equipment $equipment)
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

        $photo = $equipment->photos()->create($validated);

        return new PhotoResource($photo);
    }
}
