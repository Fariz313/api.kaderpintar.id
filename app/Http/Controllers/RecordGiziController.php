<?php

namespace App\Http\Controllers;

use App\Exports\RecordGiziExport;
use App\Models\RecordGizi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RecordGiziController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start with a base query
        $query = RecordGizi::select(
            'record_gizi.id',
            'record_gizi.user_id',
            'users.name',
            'record_gizi.recorded_by',
            'record_gizi.weight',
            'record_gizi.height',
            'record_gizi.age',
            'record_gizi.created_at',
            'record_gizi.updated_at',
            'user.gender'
            )->join('users', 'users.id', '=', 'record_gizi.user_id');

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
            $export = new RecordGiziExport($query);
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
        return view('record_gizi.create');
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
            'age' => 'nullable|numeric',
        ]);

        RecordGizi::create($request->all());

        return response()->json([
            'message' => 'Users retrieved successfully',
            'data' => [],
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Start with a base query
        $query = RecordGizi::select('record_gizi.*', 'users.name')->join('users', 'users.id', '=', 'record_gizi.user_id');

        // Paginate the results
        $users = $query->find($id);

        return response()->json($users);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecordGizi $recordGizi)
    {
        return view('record_gizi.edit', compact('recordGizi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecordGizi $recordGizi)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'age' => 'nullable|numeric',
        ]);

        $recordGizi->update($request->all());

        return redirect()->route('record_gizi.index')
            ->with('success', 'Record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        RecordGizi::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Users retrieved successfully',
            'data' => [],
        ], 200);
    }
}