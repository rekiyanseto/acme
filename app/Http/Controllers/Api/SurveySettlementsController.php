<?php

namespace App\Http\Controllers\Api;

use App\Models\Survey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettlementResource;
use App\Http\Resources\SettlementCollection;

class SurveySettlementsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey $survey
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Survey $survey)
    {
        $this->authorize('view', $survey);

        $search = $request->get('search', '');

        $settlements = $survey
            ->settlements()
            ->search($search)
            ->latest()
            ->paginate();

        return new SettlementCollection($settlements);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey $survey
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Survey $survey)
    {
        $this->authorize('create', Settlement::class);

        $validated = $request->validate([
            'settlement_condition' => ['required', 'max:255', 'string'],
            'settlement_note' => ['nullable', 'max:255', 'string'],
            'settlement_document' => ['nullable', 'max:255', 'string'],
        ]);

        $settlement = $survey->settlements()->create($validated);

        return new SettlementResource($settlement);
    }
}
