<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use Illuminate\Support\Facades\App;

class CompanyController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Company::class);

        $search = $request->get('search', '');

        $companies = Company::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.companies.index', compact('companies', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Company::class);

        return view('app.companies.create');
    }

    /**
     * @param \App\Http\Requests\CompanyStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyStoreRequest $request)
    {
        $this->authorize('create', Company::class);

        $validated = $request->validated();
        if ($request->hasFile('company_site_plan')) {
            $validated['company_site_plan'] = $request
                ->file('company_site_plan')
                ->store('public');
        }

        $company = Company::create($validated);

        return redirect()
            ->route('companies.edit', $company)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Company $company)
    {
        $this->authorize('view', $company);

        $current_node = "Company_" . $company->id;
        $current_company = $company;
        $companies = Company::with('businessUnits.functionalLocations.areas.subAreas')->get();
        $tree_data = array();
        foreach ($companies as $company_tree) {
            $company_array = array();
            $company_array["id"] = "Company_" . $company_tree->id;
            $company_array["text"] = $company_tree->company_name;
            $company_array["link"] = App::make('url')->to('/companies/' . $company_tree->id);
            if ($company_tree->id == $current_company->id) {
                $company_array["expanded"] = true;
            }
            if ($company_tree->businessUnits != null) {
                $company_array["items"] = array();
                foreach ($company->businessUnits as $businessUnit) {
                    $businessUnit_array = array();
                    $businessUnit_array["id"] = "Business Unit_" . $businessUnit->id;
                    $businessUnit_array["text"] = $businessUnit->business_unit_name;
                    $businessUnit_array["link"] = App::make('url')->to('/business-units/' . $businessUnit->id);
                    
                    if ($businessUnit->functionalLocations != null) {
                        $businessUnit_array["items"] = array();
                        foreach ($businessUnit->functionalLocations as $functionalLocation) {
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

        return view('app.companies.show', compact('company', 'tree_json', 'current_node'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Company $company)
    {
        $this->authorize('update', $company);

        return view('app.companies.edit', compact('company'));
    }

    /**
     * @param \App\Http\Requests\CompanyUpdateRequest $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyUpdateRequest $request, Company $company)
    {
        $this->authorize('update', $company);

        $validated = $request->validated();
        if ($request->hasFile('company_site_plan')) {
            if ($company->company_site_plan) {
                Storage::delete($company->company_site_plan);
            }

            $validated['company_site_plan'] = $request
                ->file('company_site_plan')
                ->store('public');
        }

        $company->update($validated);

        return redirect()
            ->route('companies.edit', $company)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Company $company)
    {
        $this->authorize('delete', $company);

        if ($company->company_site_plan) {
            Storage::delete($company->company_site_plan);
        }

        $company->delete();

        return redirect()
            ->route('companies.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
