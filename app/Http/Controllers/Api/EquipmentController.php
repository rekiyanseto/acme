<?php

namespace App\Http\Controllers\Api;

use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EquipmentResource;
use App\Http\Resources\EquipmentCollection;
use App\Http\Requests\EquipmentStoreRequest;
use App\Http\Requests\EquipmentUpdateRequest;

class EquipmentController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Equipment::class);

        $search = $request->get('search', '');

        $equipments = Equipment::search($search)
            ->latest()
            ->paginate();

        return new EquipmentCollection($equipments);
    }

    /**
     * @param \App\Http\Requests\EquipmentStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EquipmentStoreRequest $request)
    {
        $this->authorize('create', Equipment::class);

        $validated = $request->validated();

        $equipment = Equipment::create($validated);

        return new EquipmentResource($equipment);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Equipment $equipment
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Equipment $equipment)
    {
        $this->authorize('view', $equipment);

        return new EquipmentResource($equipment);
    }

    /**
     * @param \App\Http\Requests\EquipmentUpdateRequest $request
     * @param \App\Models\Equipment $equipment
     * @return \Illuminate\Http\Response
     */
    public function update(
        EquipmentUpdateRequest $request,
        Equipment $equipment
    ) {
        $this->authorize('update', $equipment);

        $validated = $request->validated();

        $equipment->update($validated);

        return new EquipmentResource($equipment);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Equipment $equipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Equipment $equipment)
    {
        $this->authorize('delete', $equipment);

        $equipment->delete();

        return response()->noContent();
    }
}
