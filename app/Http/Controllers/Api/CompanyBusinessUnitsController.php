<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessUnitResource;
use App\Http\Resources\BusinessUnitCollection;

class CompanyBusinessUnitsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Company $company)
    {
        $this->authorize('view', $company);

        $search = $request->get('search', '');

        $businessUnits = $company
            ->businessUnits()
            ->search($search)
            ->latest()
            ->paginate();

        return new BusinessUnitCollection($businessUnits);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        $this->authorize('create', BusinessUnit::class);

        $validated = $request->validate([
            'business_unit_code' => [
                'required',
                'unique:business_units,business_unit_code',
                'max:255',
                'string',
            ],
            'business_unit_name' => ['required', 'max:255', 'string'],
            'business_unit_site_plan' => ['nullable', 'mimes:jpg,jpeg,png'],
        ]);

        if ($request->hasFile('business_unit_site_plan')) {
            $validated['business_unit_site_plan'] = $request
                ->file('business_unit_site_plan')
                ->store('public');
        }

        $businessUnit = $company->businessUnits()->create($validated);

        return new BusinessUnitResource($businessUnit);
    }
}
