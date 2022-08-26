<?php

namespace App\Http\Controllers\Api;

use App\Models\BusinessUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\BusinessUnitResource;
use App\Http\Resources\BusinessUnitCollection;
use App\Http\Requests\BusinessUnitStoreRequest;
use App\Http\Requests\BusinessUnitUpdateRequest;

class BusinessUnitController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', BusinessUnit::class);

        $search = $request->get('search', '');

        $businessUnits = BusinessUnit::search($search)
            ->latest()
            ->paginate();

        return new BusinessUnitCollection($businessUnits);
    }

    /**
     * @param \App\Http\Requests\BusinessUnitStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BusinessUnitStoreRequest $request)
    {
        $this->authorize('create', BusinessUnit::class);

        $validated = $request->validated();
        if ($request->hasFile('business_unit_site_plan')) {
            $validated['business_unit_site_plan'] = $request
                ->file('business_unit_site_plan')
                ->store('public');
        }

        $businessUnit = BusinessUnit::create($validated);

        return new BusinessUnitResource($businessUnit);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BusinessUnit $businessUnit
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, BusinessUnit $businessUnit)
    {
        $this->authorize('view', $businessUnit);

        return new BusinessUnitResource($businessUnit);
    }

    /**
     * @param \App\Http\Requests\BusinessUnitUpdateRequest $request
     * @param \App\Models\BusinessUnit $businessUnit
     * @return \Illuminate\Http\Response
     */
    public function update(
        BusinessUnitUpdateRequest $request,
        BusinessUnit $businessUnit
    ) {
        $this->authorize('update', $businessUnit);

        $validated = $request->validated();

        if ($request->hasFile('business_unit_site_plan')) {
            if ($businessUnit->business_unit_site_plan) {
                Storage::delete($businessUnit->business_unit_site_plan);
            }

            $validated['business_unit_site_plan'] = $request
                ->file('business_unit_site_plan')
                ->store('public');
        }

        $businessUnit->update($validated);

        return new BusinessUnitResource($businessUnit);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BusinessUnit $businessUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, BusinessUnit $businessUnit)
    {
        $this->authorize('delete', $businessUnit);

        if ($businessUnit->business_unit_site_plan) {
            Storage::delete($businessUnit->business_unit_site_plan);
        }

        $businessUnit->delete();

        return response()->noContent();
    }
}
