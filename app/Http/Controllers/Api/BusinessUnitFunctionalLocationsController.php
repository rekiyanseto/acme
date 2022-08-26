<?php

namespace App\Http\Controllers\Api;

use App\Models\BusinessUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FunctionalLocationResource;
use App\Http\Resources\FunctionalLocationCollection;

class BusinessUnitFunctionalLocationsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BusinessUnit $businessUnit
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, BusinessUnit $businessUnit)
    {
        $this->authorize('view', $businessUnit);

        $search = $request->get('search', '');

        $functionalLocations = $businessUnit
            ->functionalLocations()
            ->search($search)
            ->latest()
            ->paginate();

        return new FunctionalLocationCollection($functionalLocations);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BusinessUnit $businessUnit
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, BusinessUnit $businessUnit)
    {
        $this->authorize('create', FunctionalLocation::class);

        $validated = $request->validate([
            'functional_location_code' => [
                'required',
                'unique:functional_locations,functional_location_code',
                'max:255',
                'string',
            ],
            'functional_location_name' => ['required', 'max:255', 'string'],
            'functional_location_site_plan' => [
                'nullable',
                'mimes:jpg,jpeg,png',
            ],
        ]);

        if ($request->hasFile('functional_location_site_plan')) {
            $validated['functional_location_site_plan'] = $request
                ->file('functional_location_site_plan')
                ->store('public');
        }

        $functionalLocation = $businessUnit
            ->functionalLocations()
            ->create($validated);

        return new FunctionalLocationResource($functionalLocation);
    }
}
