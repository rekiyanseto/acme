<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Models\FunctionalLocation;
use App\Http\Requests\AreaStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AreaUpdateRequest;
use App\Models\BusinessUnit;
use App\Models\Company;
use Illuminate\Support\Facades\App;

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
            ->paginate(5)
            ->withQueryString();

        return view('app.areas.index', compact('areas', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Area::class);

        $functionalLocations = FunctionalLocation::pluck(
            'functional_location_name',
            'id'
        );

        return view('app.areas.create', compact('functionalLocations'));
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

        return redirect()
            ->route('areas.edit', $area)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Area $area
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Area $area)
    {
        $this->authorize('view', $area);

        $current_node = "Area_" . $area->id;
        $current_area = $area;
        $current_funloc = FunctionalLocation::find($current_area->functional_location_id);
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
                        foreach ($businessUnit->functionalLocations as $functionalLocation) {
                            $functionalLocation_array = array();
                            $functionalLocation_array["id"] = "Functional Locaton_" . $functionalLocation->id;
                            $functionalLocation_array["text"] = $functionalLocation->functional_location_name;
                            $functionalLocation_array["link"] = App::make('url')->to('/functional-locations/' . $functionalLocation->id);
                            if ($functionalLocation->id == $current_funloc->id) {
                                $functionalLocation_array["expanded"] = true;
                            }
                            if ($functionalLocation->areas != null) {
                                $functionalLocation_array["items"] = array();
                                foreach ($functionalLocation->areas as $area_tree) {
                                    $area_array = array();
                                    $area_array["id"] = "Area_" . $area_tree->id;
                                    $area_array["text"] = $area_tree->area_name;
                                    $area_array["link"] = App::make('url')->to('/areas/' . $area_tree->id);
                                    if ($area_tree->id == $current_area->id) {
                                        $area_array["expanded"] = true;
                                    }
                                    if ($area_tree->subAreas != null) {
                                        $area_array["items"] = array();
                                        foreach ($area_tree->subAreas as $subArea) {
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

        return view('app.areas.show', compact('area', 'tree_json', 'current_node'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Area $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Area $area)
    {
        $this->authorize('update', $area);

        $functionalLocations = FunctionalLocation::pluck(
            'functional_location_name',
            'id'
        );

        return view('app.areas.edit', compact('area', 'functionalLocations'));
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

        return redirect()
            ->route('areas.edit', $area)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('areas.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
