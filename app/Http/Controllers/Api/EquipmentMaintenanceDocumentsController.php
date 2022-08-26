<?php

namespace App\Http\Controllers\Api;

use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MaintenanceDocumentResource;
use App\Http\Resources\MaintenanceDocumentCollection;

class EquipmentMaintenanceDocumentsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Equipment $equipment
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Equipment $equipment)
    {
        $this->authorize('view', $equipment);

        $search = $request->get('search', '');

        $maintenanceDocuments = $equipment
            ->maintenanceDocuments()
            ->search($search)
            ->latest()
            ->paginate();

        return new MaintenanceDocumentCollection($maintenanceDocuments);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Equipment $equipment
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Equipment $equipment)
    {
        $this->authorize('create', MaintenanceDocument::class);

        $validated = $request->validate([
            'document_name' => ['required', 'max:255', 'string'],
            'document_remarks' => ['nullable', 'max:255', 'string'],
            'document_file' => ['file', 'required'],
        ]);

        if ($request->hasFile('document_file')) {
            $validated['document_file'] = $request
                ->file('document_file')
                ->store('public');
        }

        $maintenanceDocument = $equipment
            ->maintenanceDocuments()
            ->create($validated);

        return new MaintenanceDocumentResource($maintenanceDocument);
    }
}
