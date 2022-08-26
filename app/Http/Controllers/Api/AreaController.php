<?php

namespace App\Http\Controllers\Api;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Resources\AreaResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\AreaCollection;
use App\Http\Requests\AreaStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AreaUpdateRequest;

class AreaController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Area::class);

        $search = $request->get('search', '');

        $areas = Area::search($search)
            ->latest()
            ->paginate();

        return new AreaCollection($areas);
    }

    /**
     * @param \App\Http\Requests\AreaStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AreaStoreRequest $request)
    {
        $this->authorize('create', Area::class);

        $validated = $request->validated();
        if ($request->hasFile('area_site_plan')) {
            $validated['area_site_plan'] = $request
                ->file('area_site_plan')
                ->store('public');
        }

        $area = Area::create($validated);

        return new AreaResource($area);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Area $area
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Area $area)
    {
        $this->authorize('view', $area);

        return new AreaResource($area);
    }

    /**
     * @param \App\Http\Requests\AreaUpdateRequest $request
     * @param \App\Models\Area $area
     * @return \Illuminate\Http\Response
     */
    public function update(AreaUpdateRequest $request, Area $area)
    {
        $this->authorize('update', $area);

        $validated = $request->validated();

        if ($request->hasFile('area_site_plan')) {
            if ($area->area_site_plan) {
                Storage::delete($area->area_site_plan);
            }

            $validated['area_site_plan'] = $request
                ->file('area_site_plan')
                ->store('public');
        }

        $area->update($validated);

        return new AreaResource($area);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Area $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Area $area)
    {
        $this->authorize('delete', $area);

        if ($area->area_site_plan) {
            Storage::delete($area->area_site_plan);
        }

        $area->delete();

        return response()->noContent();
    }
}
