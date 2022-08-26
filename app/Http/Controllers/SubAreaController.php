<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\SubArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SubAreaStoreRequest;
use App\Http\Requests\SubAreaUpdateRequest;
use App\Models\BusinessUnit;
use App\Models\Company;
use App\Models\FunctionalLocation;
use Illuminate\Support\Facades\App;

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
            ->paginate(5)
            ->withQueryString();

        return view('app.sub_areas.index', compact('subAreas', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', SubArea::class);

        $areas = Area::pluck('area_name', 'id');

        return view('app.sub_areas.create', compact('areas'));
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

        return redirect()
            ->route('sub-areas.edit', $subArea)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubArea $subArea
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SubArea $subArea)
    {
        $this->authorize('view', $subArea);

        $current_node = "Sub Area_" . $subArea->id;
        $current_subArea = $subArea;
        $current_area = Area::find($current_subArea->area_id);
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
                                foreach ($functionalLocation->areas as $area) {
                                    $area_array = array();
                                    $area_array["id"] = "Area_" . $area->id;
                                    $area_array["text"] = $area->area_name;
                                    $area_array["link"] = App::make('url')->to('/areas/' . $area->id);
                                    if ($area->id == $current_area->id) {
                                        $area_array["expanded"] = true;
                                    }
                                    if ($area->subAreas != null) {
                                        $area_array["items"] = array();
                                        foreach ($area->subAreas as $tree_subArea) {
                                            $subArea_array = array();
                                            $subArea_array["id"] = "Sub Area_" . $tree_subArea->id;
                                            $subArea_array["text"] = $tree_subArea->sub_area_name;
                                            $subArea_array["link"] = App::make('url')->to('/sub-areas/' . $tree_subArea->id);
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
        return view('app.sub_areas.show', compact('subArea', 'tree_json', 'current_node'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubArea $subArea
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SubArea $subArea)
    {
        $this->authorize('update', $subArea);

        $areas = Area::pluck('area_name', 'id');

        return view('app.sub_areas.edit', compact('subArea', 'areas'));
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

        return redirect()
            ->route('sub-areas.edit', $subArea)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('sub-areas.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
