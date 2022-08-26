<?php

namespace App\Http\Controllers\Api;

use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentResource;
use App\Http\Resources\DocumentCollection;

class EquipmentDocumentsController extends Controller
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

        $documents = $equipment
            ->documents()
            ->search($search)
            ->latest()
            ->paginate();

        return new DocumentCollection($documents);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Equipment $equipment
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Equipment $equipment)
    {
        $this->authorize('create', Document::class);

        $validated = $request->validate([
            'document_name' => [
                'required',
                'unique:documents,document_name',
                'max:255',
                'string',
            ],
            'document_description' => ['nullable', 'max:255', 'string'],
            'document_link' => ['file', 'required'],
        ]);

        if ($request->hasFile('document_link')) {
            $validated['document_link'] = $request
                ->file('document_link')
                ->store('public');
        }

        $document = $equipment->documents()->create($validated);

        return new DocumentResource($document);
    }
}
