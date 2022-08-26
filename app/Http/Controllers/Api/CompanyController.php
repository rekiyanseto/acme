<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CompanyCollection;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;

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
            ->paginate();

        return new CompanyCollection($companies);
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

        return new CompanyResource($company);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Company $company)
    {
        $this->authorize('view', $company);

        return new CompanyResource($company);
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

        return new CompanyResource($company);
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

        return response()->noContent();
    }
}
