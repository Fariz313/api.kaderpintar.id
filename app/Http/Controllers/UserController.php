<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start with a base query  
        $query = User::query();

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

        // Paginate the results
        $users = $query->paginate(10);

        return response()->json([
            'message' => 'Users retrieved successfully',
            'data' => $users,
        ], 200);
    }

    public function all(Request $request)
    {
        // Start with a base query
        $query = User::query();

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'nullable|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // $user = User::create($request->all());
        $user = User::create([
            ...$request->all(),
            'password' => $request->password ? Hash::make($request->password) : null,
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }


    function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to log in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            return response()->json(['message' => 'Login successful', 'token' => $user->createToken('token-name')->plainTextToken, 'user' => $user], 200);
        }

        // Failed login attempt
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Logout successful'], 200);
    }

    public function me(Request $request)
    {
        $user = Auth::user();
        return response()->json(['message' => 'Get me successful', 'user' => $user], 200);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        // Remove only null values (keeping false, 0, etc.)
        $filteredData = array_filter($request->all(), function ($value) {
            return !is_null($value);
        });

        $user->update($filteredData);

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }   
}
