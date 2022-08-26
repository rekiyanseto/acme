<?php

namespace App\Http\Controllers\Api;

use App\Models\SubArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MaintenanceDocumentResource;
use App\Http\Resources\MaintenanceDocumentCollection;

class SubAreaMaintenanceDocumentsController extends Controller
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

        $maintenanceDocuments = $subArea
            ->maintenanceDocuments()
            ->search($search)
            ->latest()
            ->paginate();

        return new MaintenanceDocumentCollection($maintenanceDocuments);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubArea $subArea
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SubArea $subArea)
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

        $maintenanceDocument = $subArea
            ->maintenanceDocuments()
            ->create($validated);

        return new MaintenanceDocumentResource($maintenanceDocument);
    }
}
