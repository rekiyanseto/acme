<?php

namespace App\Http\Controllers\Api;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubAreaResource;
use App\Http\Resources\SubAreaCollection;

class AreaSubAreasController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Area $area
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Area $area)
    {
        $this->authorize('view', $area);

        $search = $request->get('search', '');

        $subAreas = $area
            ->subAreas()
            ->search($search)
            ->latest()
            ->paginate();

        return new SubAreaCollection($subAreas);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Area $area
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Area $area)
    {
        $this->authorize('create', SubArea::class);

        $validated = $request->validate([
            'sub_area_code' => [
                'required',
                'unique:sub_areas,sub_area_code',
                'max:255',
                'string',
            ],
            'sub_area_name' => ['required', 'max:255', 'string'],
            'maintenance_by' => ['nullable', 'max:255', 'string'],
            'sub_area_description' => ['nullable', 'max:255', 'string'],
            'sub_area_site_plan' => ['nullable', 'mimes:jpg,jpeg,png'],
        ]);

        if ($request->hasFile('sub_area_site_plan')) {
            $validated['sub_area_site_plan'] = $request
                ->file('sub_area_site_plan')
                ->store('public');
        }

        $subArea = $area->subAreas()->create($validated);

        return new SubAreaResource($subArea);
    }
}
