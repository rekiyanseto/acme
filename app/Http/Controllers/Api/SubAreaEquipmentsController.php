<?php

namespace App\Http\Controllers\Api;

use App\Models\SubArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EquipmentResource;
use App\Http\Resources\EquipmentCollection;

class SubAreaEquipmentsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubArea $subArea
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SubArea $subArea)
    {
        $this->authorize('view', $subArea);

        $search = $request->get('search', '');

        $equipments = $subArea
            ->equipments()
            ->search($search)
            ->latest()
            ->paginate();

        return new EquipmentCollection($equipments);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubArea $subArea
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SubArea $subArea)
    {
        $this->authorize('create', Equipment::class);

        $validated = $request->validate([
            'equipment_code' => [
                'required',
                'unique:equipment,equipment_code',
                'max:255',
                'string',
            ],
            'equipment_name' => ['required', 'max:255', 'string'],
            'maintenance_by' => ['nullable', 'max:255', 'string'],
            'equipment_description' => ['nullable', 'max:255', 'string'],
        ]);

        $equipment = $subArea->equipments()->create($validated);

        return new EquipmentResource($equipment);
    }
}
