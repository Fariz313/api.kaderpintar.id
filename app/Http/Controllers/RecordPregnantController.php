<?php

namespace App\Http\Controllers;

use App\Exports\RecordPregnantExport;
use App\Models\RecordPregnant;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RecordPregnantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start with a base query
        $query = RecordPregnant::select(
            'record_pregnants.id',
            'record_pregnants.user_id',
            'users.name',
            'record_pregnants.recorded_by',
            'record_pregnants.weight',
            'record_pregnants.height',
            'record_pregnants.age_at_pregnancy',
            'record_pregnants.young_pregnant',
            'record_pregnants.old_pregnant',
            'record_pregnants.overlong_pregnant',
            'record_pregnants.late_pregnant',
            'record_pregnants.early_pregnant',
            'record_pregnants.much_child',
            'record_pregnants.miscarriage',
            'record_pregnants.vacum_birth',
            'record_pregnants.retained_placenta',
            'record_pregnants.tranfused',
            'record_pregnants.csection',
            'record_pregnants.anemia',
            'record_pregnants.malaria',
            'record_pregnants.tbc',
            'record_pregnants.hearth_failure',
            'record_pregnants.std',
            'record_pregnants.hypertension',
            'record_pregnants.twin_birth',
            'record_pregnants.hydranion',
            'record_pregnants.over_pregnant',
            'record_pregnants.death_baby',
            'record_pregnants.breech',
            'record_pregnants.oblique',
            'record_pregnants.preeklampsia',
            'record_pregnants.diabetes',
            'record_pregnants.created_at',
            'record_pregnants.updated_at'
        )->join('users', 'users.id', '=', 'record_pregnants.user_id');

        // Check if the search parameter is provided
        if ($request->has('search')) {
            $searchTerm = $request->input('search');

            // Apply search with priority: name > address > phone
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%') // Priority 1: name
                    ->orWhere('address', 'like', '%' . $searchTerm . '%') // Priority 2: address
                    ->orWhere('phone', 'like', '%' . $searchTerm . '%'); // Priority 3: phone
            });
        }

        if ($request->boolean('export')) {
            $export = new RecordPregnantExport($query);
            return Excel::download($export, 'record-pregnant.xlsx');
            // return response()->json($query->get());
        }
        // Paginate the results
        $users = $query->paginate(10);

        return response()->json([
            'message' => 'Users retrieved successfully',
            'data' => $users,
        ], 200);
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

        return response()->json([
            'message' => 'Record retrieved successfully',
            'data' => [],
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Start with a base query
        $query = RecordPregnant::select('record_pregnants.*', 'users.name')->join('users', 'users.id', '=', 'record_pregnants.user_id');

        // Paginate the results
        $users = $query->find($id);

        return response()->json($users, 200);
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

        return response()->json([
            'message' => 'Record deleted successfully',
            'data' => [],
        ], 200);
    }
}