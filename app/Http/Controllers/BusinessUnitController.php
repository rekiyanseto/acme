<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\BusinessUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BusinessUnitStoreRequest;
use App\Http\Requests\BusinessUnitUpdateRequest;
use Illuminate\Support\Facades\App;

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
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.business_units.index',
            compact('businessUnits', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', BusinessUnit::class);

        $companies = Company::pluck('company_code', 'id');

        return view('app.business_units.create', compact('companies'));
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

        return redirect()
            ->route('business-units.edit', $businessUnit)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BusinessUnit $businessUnit
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, BusinessUnit $businessUnit)
    {
        $this->authorize('view', $businessUnit);

        $current_node = "Business Unit_" . $businessUnit->id;
        $current_businessUnit = $businessUnit;
        $current_company = Company::find($current_businessUnit->company_id);
        $companies = Company::with('businessUnits.functionalLocations.areas.subAreas')->get();
        $tree_data = array();
        foreach ($companies as $company) {
            $company_array = array();
            $company_array["id"] = "Company_" . $company->id;
            $company_array["text"] = $company->company_name;
            $company_array["link"] = App::make('url')->to('/companies/' . $company->id);
            if ($company->id == $current_company->id) {
                $company_array["expanded"] = true;
            }
            if ($company->businessUnits != null) {
                $company_array["items"] = array();
                foreach ($company->businessUnits as $businessUnit_tree) {
                    $businessUnit_array = array();
                    $businessUnit_array["id"] = "Business Unit_" . $businessUnit_tree->id;
                    $businessUnit_array["text"] = $businessUnit_tree->business_unit_name;
                    $businessUnit_array["link"] = App::make('url')->to('/business-units/' . $businessUnit_tree->id);
                    if ($businessUnit_tree->id == $current_businessUnit->id) {
                        $businessUnit_array["expanded"] = true;
                    }
                    if ($businessUnit_tree->functionalLocations != null) {
                        $businessUnit_array["items"] = array();
                        foreach ($businessUnit_tree->functionalLocations as $functionalLocation) {
                            $functionalLocation_array = array();
                            $functionalLocation_array["id"] = "Functional Locaton_" . $functionalLocation->id;
                            $functionalLocation_array["text"] = $functionalLocation->functional_location_name;
                            $functionalLocation_array["link"] = App::make('url')->to('/functional-locations/' . $functionalLocation->id);
                            
                            if ($functionalLocation->areas != null) {
                                $functionalLocation_array["items"] = array();
                                foreach ($functionalLocation->areas as $area) {
                                    $area_array = array();
                                    $area_array["id"] = "Area_" . $area->id;
                                    $area_array["text"] = $area->area_name;
                                    $area_array["link"] = App::make('url')->to('/areas/' . $area->id);
                                    
                                    if ($area->subAreas != null) {
                                        $area_array["items"] = array();
                                        foreach ($area->subAreas as $subArea) {
                                            $subArea_array = array();
                                            $subArea_array["id"] = "Sub Area_" . $subArea->id;
                                            $subArea_array["text"] = $subArea->sub_area_name;
                                            $subArea_array["link"] = App::make('url')->to('/sub-areas/' . $subArea->id);
                                            array_push($area_array["items"], $subArea_array);
                                        }
                                    }
                                    array_push($functionalLocation_array["items"], $area_array);
                                }
                            }
                            array_push($businessUnit_array["items"], $functionalLocation_array);
                        }
                    }
                    array_push($company_array["items"], $businessUnit_array);
                }
            }
            array_push($tree_data, $company_array);
        }
        $tree_json = json_encode($tree_data);
        
        return view('app.business_units.show', compact('businessUnit', 'tree_json', 'current_node'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BusinessUnit $businessUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, BusinessUnit $businessUnit)
    {
        $this->authorize('update', $businessUnit);

        $companies = Company::pluck('company_code', 'id');

        return view(
            'app.business_units.edit',
            compact('businessUnit', 'companies')
        );
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

        return redirect()
            ->route('business-units.edit', $businessUnit)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('business-units.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
