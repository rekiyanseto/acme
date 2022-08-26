<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\FunctionalLocation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\FunctionalLocationResource;
use App\Http\Resources\FunctionalLocationCollection;
use App\Http\Requests\FunctionalLocationStoreRequest;
use App\Http\Requests\FunctionalLocationUpdateRequest;

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
            ->paginate();

        return new FunctionalLocationCollection($functionalLocations);
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

        return new FunctionalLocationResource($functionalLocation);
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

        return new FunctionalLocationResource($functionalLocation);
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

        return new FunctionalLocationResource($functionalLocation);
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

        return response()->noContent();
    }
}
