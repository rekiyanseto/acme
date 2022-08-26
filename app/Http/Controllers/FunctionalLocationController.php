<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessUnit;
use App\Models\FunctionalLocation;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FunctionalLocationStoreRequest;
use App\Http\Requests\FunctionalLocationUpdateRequest;
use App\Models\Company;
use Illuminate\Support\Facades\App;

class FunctionalLocationController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', FunctionalLocation::class);

        $search = $request->get('search', '');

        $functionalLocations = FunctionalLocation::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.functional_locations.index',
            compact('functionalLocations', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', FunctionalLocation::class);

        $businessUnits = BusinessUnit::pluck('business_unit_name', 'id');

        return view(
            'app.functional_locations.create',
            compact('businessUnits')
        );
    }

    /**
     * @param \App\Http\Requests\FunctionalLocationStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FunctionalLocationStoreRequest $request)
    {
        $this->authorize('create', FunctionalLocation::class);

        $validated = $request->validated();
        if ($request->hasFile('functional_location_site_plan')) {
            $validated['functional_location_site_plan'] = $request
                ->file('functional_location_site_plan')
                ->store('public');
        }

        $functionalLocation = FunctionalLocation::create($validated);

        return redirect()
            ->route('functional-locations.edit', $functionalLocation)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FunctionalLocation $functionalLocation
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        FunctionalLocation $functionalLocation
    ) {
        $this->authorize('view', $functionalLocation);

        $current_node = "Functional Locaton_" . $functionalLocation->id;

        $current_funloc = $functionalLocation;
        $current_businessUnit = BusinessUnit::find($current_funloc->business_unit_id);
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
                foreach ($company->businessUnits as $businessUnit) {
                    $businessUnit_array = array();
                    $businessUnit_array["id"] = "Business Unit_" . $businessUnit->id;
                    $businessUnit_array["text"] = $businessUnit->business_unit_name;
                    $businessUnit_array["link"] = App::make('url')->to('/business-units/' . $businessUnit->id);
                    if ($businessUnit->id == $current_businessUnit->id) {
                        $businessUnit_array["expanded"] = true;
                    }
                    if ($businessUnit->functionalLocations != null) {
                        $businessUnit_array["items"] = array();
                        foreach ($businessUnit->functionalLocations as $functionalLocation_tree) {
                            $functionalLocation_array = array();
                            $functionalLocation_array["id"] = "Functional Locaton_" . $functionalLocation_tree->id;
                            $functionalLocation_array["text"] = $functionalLocation_tree->functional_location_name;
                            $functionalLocation_array["link"] = App::make('url')->to('/functional-locations/' . $functionalLocation_tree->id);
                            if ($functionalLocation_tree->id == $current_funloc->id) {
                                $functionalLocation_array["expanded"] = true;
                            }
                            if ($functionalLocation_tree->areas != null) {
                                $functionalLocation_array["items"] = array();
                                foreach ($functionalLocation_tree->areas as $area) {
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

        return view(
            'app.functional_locations.show',
            compact('functionalLocation', 'tree_json', 'current_node')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FunctionalLocation $functionalLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(
        Request $request,
        FunctionalLocation $functionalLocation
    ) {
        $this->authorize('update', $functionalLocation);

        $businessUnits = BusinessUnit::pluck('business_unit_name', 'id');

        return view(
            'app.functional_locations.edit',
            compact('functionalLocation', 'businessUnits')
        );
    }

    /**
     * @param \App\Http\Requests\FunctionalLocationUpdateRequest $request
     * @param \App\Models\FunctionalLocation $functionalLocation
     * @return \Illuminate\Http\Response
     */
    public function update(
        FunctionalLocationUpdateRequest $request,
        FunctionalLocation $functionalLocation
    ) {
        $this->authorize('update', $functionalLocation);

        $validated = $request->validated();
        if ($request->hasFile('functional_location_site_plan')) {
            if ($functionalLocation->functional_location_site_plan) {
                Storage::delete(
                    $functionalLocation->functional_location_site_plan
                );
            }

            $validated['functional_location_site_plan'] = $request
                ->file('functional_location_site_plan')
                ->store('public');
        }

        $functionalLocation->update($validated);

        return redirect()
            ->route('functional-locations.edit', $functionalLocation)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FunctionalLocation $functionalLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        FunctionalLocation $functionalLocation
    ) {
        $this->authorize('delete', $functionalLocation);

        if ($functionalLocation->functional_location_site_plan) {
            Storage::delete($functionalLocation->functional_location_site_plan);
        }

        $functionalLocation->delete();

        return redirect()
            ->route('functional-locations.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
