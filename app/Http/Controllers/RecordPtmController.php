<?php

namespace App\Http\Controllers;

use App\Exports\RecordPtmExport;
use App\Models\RecordPtm;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class RecordPtmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start with a base query
        $query = RecordPtm::select(
            'records_ptm.id',
            'records_ptm.user_id',
            'users.name',
            'records_ptm.recorded_by',
            'records_ptm.weight',
            'records_ptm.height',
            'records_ptm.BP',
            'records_ptm.BP2',
            'records_ptm.GDS',
            'records_ptm.GDP',
            'records_ptm.created_at',
            'records_ptm.updated_at')->join('users', 'users.id', '=', 'records_ptm.user_id')->orderBy('created_at', 'desc');

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
            $export = new RecordPtmExport($query);
            return Excel::download($export, 'record-ptm.xlsx');
        } else {
            $users = $query->paginate(10);
            return response()->json([
                'message' => 'Users retrieved successfully',
                'data' => $users,
            ], 200);
        }
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
        $query = RecordPtm::select('records_ptm.*', 'users.name')->join('users', 'users.id', '=', 'records_ptm.user_id');

        // Paginate the results
        $users = $query->find($id);

        return response()->json($users, 200);
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
    public function destroy(Request $request, $id)
    {
        RecordPtm::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Users retrieved successfully',
            'data' => [],
        ], 200);
    }
}