<?php

namespace App\Http\Controllers;

use App\Models\RecordPregnant;
use Illuminate\Http\Request;

class RecordPregnantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = RecordPregnant::all();
        return view('records_pregnant.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('records_pregnant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'recorded_by' => 'nullable|exists:users,id',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'age_at_pregnancy' => 'nullable|numeric',
            'young_pregnant' => 'nullable|boolean',
            'old_pregnant' => 'nullable|boolean',
            'overlong_pregnant' => 'nullable|boolean',
            'late_pregnant' => 'nullable|boolean',
            'early_pregnant' => 'nullable|boolean',
            'much_child' => 'nullable|boolean',
            'miscarriage' => 'nullable|boolean',
            'vacum_birth' => 'nullable|boolean',
            'retained_placenta' => 'nullable|boolean',
            'tranfused' => 'nullable|boolean',
            'csection' => 'nullable|boolean',
            'anemia' => 'nullable|boolean',
            'malaria' => 'nullable|boolean',
            'tbc' => 'nullable|boolean',
            'hearth_failure' => 'nullable|boolean',
            'std' => 'nullable|boolean',
            'hypertension' => 'nullable|boolean',
            'twin_birth' => 'nullable|boolean',
            'hydranion' => 'nullable|boolean',
            'over_pregnant' => 'nullable|boolean',
            'death_baby' => 'nullable|boolean',
            'breech' => 'nullable|boolean',
            'oblique' => 'nullable|boolean',
            'preeklampsia' => 'nullable|boolean',
        ]);

        RecordPregnant::create($request->all());

        return redirect()->route('records-pregnant.index')
                         ->with('success', 'Record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RecordPregnant $recordPregnant)
    {
        return view('records_pregnant.show', compact('recordPregnant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecordPregnant $recordPregnant)
    {
        return view('records_pregnant.edit', compact('recordPregnant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecordPregnant $recordPregnant)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'recorded_by' => 'nullable|exists:users,id',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'age_at_pregnancy' => 'nullable|numeric',
            'young_pregnant' => 'nullable|boolean',
            'old_pregnant' => 'nullable|boolean',
            'overlong_pregnant' => 'nullable|boolean',
            'late_pregnant' => 'nullable|boolean',
            'early_pregnant' => 'nullable|boolean',
            'much_child' => 'nullable|boolean',
            'miscarriage' => 'nullable|boolean',
            'vacum_birth' => 'nullable|boolean',
            'retained_placenta' => 'nullable|boolean',
            'tranfused' => 'nullable|boolean',
            'csection' => 'nullable|boolean',
            'anemia' => 'nullable|boolean',
            'malaria' => 'nullable|boolean',
            'tbc' => 'nullable|boolean',
            'hearth_failure' => 'nullable|boolean',
            'std' => 'nullable|boolean',
            'hypertension' => 'nullable|boolean',
            'twin_birth' => 'nullable|boolean',
            'hydranion' => 'nullable|boolean',
            'over_pregnant' => 'nullable|boolean',
            'death_baby' => 'nullable|boolean',
            'breech' => 'nullable|boolean',
            'oblique' => 'nullable|boolean',
            'preeklampsia' => 'nullable|boolean',
        ]);

        $recordPregnant->update($request->all());

        return redirect()->route('records-pregnant.index')
                         ->with('success', 'Record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecordPregnant $recordPregnant)
    {
        $recordPregnant->delete();

        return redirect()->route('records-pregnant.index')
                         ->with('success', 'Record deleted successfully.');
    }
}