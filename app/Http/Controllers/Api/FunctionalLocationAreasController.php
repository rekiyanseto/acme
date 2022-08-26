<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\FunctionalLocation;
use App\Http\Resources\AreaResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\AreaCollection;

class FunctionalLocationAreasController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FunctionalLocation $functionalLocation
     * @return \Illuminate\Http\Response
     */
    public function index(
        Request $request,
        FunctionalLocation $functionalLocation
    ) {
        $this->authorize('view', $functionalLocation);

        $search = $request->get('search', '');

        $areas = $functionalLocation
            ->areas()
            ->search($search)
            ->latest()
            ->paginate();

        return new AreaCollection($areas);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FunctionalLocation $functionalLocation
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        FunctionalLocation $functionalLocation
    ) {
        $this->authorize('create', Area::class);

        $validated = $request->validate([
            'area_code' => [
                'required',
                'unique:areas,area_code',
                'max:255',
                'string',
            ],
            'area_name' => ['required', 'max:255', 'string'],
            'area_site_plan' => ['nullable', 'mimes:jpg,jpeg,png'],
        ]);

        if ($request->hasFile('area_site_plan')) {
            $validated['area_site_plan'] = $request
                ->file('area_site_plan')
                ->store('public');
        }

        $area = $functionalLocation->areas()->create($validated);

        return new AreaResource($area);
    }
}
