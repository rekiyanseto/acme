<?php

namespace App\Http\Controllers\Api;

use App\Models\Survey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettlementByBusinessUnitResource;
use App\Http\Resources\SettlementByBusinessUnitCollection;

class SurveySettlementByBusinessUnitsController extends Controller
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

        $settlementByBusinessUnits = $survey
            ->settlementByBusinessUnits()
            ->search($search)
            ->latest()
            ->paginate();

        return new SettlementByBusinessUnitCollection(
            $settlementByBusinessUnits
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey $survey
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Survey $survey)
    {
        $this->authorize('create', SettlementByBusinessUnit::class);

        $validated = $request->validate([
            'spk_no' => ['required', 'max:255', 'string'],
            'progress' => ['required', 'numeric'],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png'],
            'condition' => ['required', 'max:255', 'string'],
            'note' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('public');
        }

        $settlementByBusinessUnit = $survey
            ->settlementByBusinessUnits()
            ->create($validated);

        return new SettlementByBusinessUnitResource($settlementByBusinessUnit);
    }
}
