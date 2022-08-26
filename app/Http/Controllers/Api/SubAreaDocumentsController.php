<?php

namespace App\Http\Controllers\Api;

use App\Models\SubArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentResource;
use App\Http\Resources\DocumentCollection;

class SubAreaDocumentsController extends Controller
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

        $documents = $subArea
            ->documents()
            ->search($search)
            ->latest()
            ->paginate();

        return new DocumentCollection($documents);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubArea $subArea
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SubArea $subArea)
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

        $document = $subArea->documents()->create($validated);

        return new DocumentResource($document);
    }
}
