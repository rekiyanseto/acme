<?php

namespace App\Http\Controllers\Api;

use App\Models\SubArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubAreaResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SubAreaCollection;
use App\Http\Requests\SubAreaStoreRequest;
use App\Http\Requests\SubAreaUpdateRequest;

class SubAreaController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', SubArea::class);

        $search = $request->get('search', '');

        $subAreas = SubArea::search($search)
            ->latest()
            ->paginate();

        return new SubAreaCollection($subAreas);
    }

    /**
     * @param \App\Http\Requests\SubAreaStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubAreaStoreRequest $request)
    {
        $this->authorize('create', SubArea::class);

        $validated = $request->validated();
        if ($request->hasFile('sub_area_site_plan')) {
            $validated['sub_area_site_plan'] = $request
                ->file('sub_area_site_plan')
                ->store('public');
        }

        $subArea = SubArea::create($validated);

        return new SubAreaResource($subArea);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubArea $subArea
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SubArea $subArea)
    {
        $this->authorize('view', $subArea);

        return new SubAreaResource($subArea);
    }

    /**
     * @param \App\Http\Requests\SubAreaUpdateRequest $request
     * @param \App\Models\SubArea $subArea
     * @return \Illuminate\Http\Response
     */
    public function update(SubAreaUpdateRequest $request, SubArea $subArea)
    {
        $this->authorize('update', $subArea);

        $validated = $request->validated();

        if ($request->hasFile('sub_area_site_plan')) {
            if ($subArea->sub_area_site_plan) {
                Storage::delete($subArea->sub_area_site_plan);
            }

            $validated['sub_area_site_plan'] = $request
                ->file('sub_area_site_plan')
                ->store('public');
        }

        $subArea->update($validated);

        return new SubAreaResource($subArea);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubArea $subArea
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SubArea $subArea)
    {
        $this->authorize('delete', $subArea);

        if ($subArea->sub_area_site_plan) {
            Storage::delete($subArea->sub_area_site_plan);
        }

        $subArea->delete();

        return response()->noContent();
    }
}
