<?php

namespace App\Http\Controllers;

use App\Models\RecordPtm;
use Illuminate\Http\Request;

class RecordPtmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = RecordPtm::all();
        return view('records_ptm.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('records_ptm.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'BP' => 'nullable|numeric',
            'GDS' => 'nullable|numeric',
            'GDP' => 'nullable|numeric',
        ]);

        RecordPtm::create($request->all());

        return redirect()->route('records_ptm.index')
                         ->with('success', 'Record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RecordPtm $recordPtm)
    {
        return view('records_ptm.show', compact('recordPtm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecordPtm $recordPtm)
    {
        return view('records_ptm.edit', compact('recordPtm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecordPtm $recordPtm)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'BP' => 'nullable|numeric',
            'GDS' => 'nullable|numeric',
            'GDP' => 'nullable|numeric',
        ]);

        $recordPtm->update($request->all());

        return redirect()->route('records_ptm.index')
                         ->with('success', 'Record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecordPtm $recordPtm)
    {
        $recordPtm->delete();

        return redirect()->route('records_ptm.index')
                         ->with('success', 'Record deleted successfully.');
    }
}