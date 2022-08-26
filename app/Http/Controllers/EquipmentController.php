<?php

namespace App\Http\Controllers;

use App\Models\SubArea;
use App\Models\Equipment;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.equipments.index', compact('equipments', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Equipment::class);

        $subAreas = SubArea::pluck('sub_area_name', 'id');

        return view('app.equipments.create', compact('subAreas'));
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

        return redirect()
            ->route('equipments.edit', $equipment)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Equipment $equipment
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Equipment $equipment)
    {
        $this->authorize('view', $equipment);

        return view('app.equipments.show', compact('equipment'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Equipment $equipment
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Equipment $equipment)
    {
        $this->authorize('update', $equipment);

        $subAreas = SubArea::pluck('sub_area_name', 'id');

        return view('app.equipments.edit', compact('equipment', 'subAreas'));
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

        return redirect()
            ->route('equipments.edit', $equipment)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('equipments.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
