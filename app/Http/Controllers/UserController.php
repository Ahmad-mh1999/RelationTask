<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return response()->json([
            'user' => $user,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string',
            'email'=> 'required|string',
        ]);
        try {
            $user = User::create([
                'name'=> $request->name,
                'email'=> $request->email,
            ]);
            $user->groups()->attach($request->group_id);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th
            ],500);
        }
        return response()->json([
            'message' => 'User Created Successfully',
            'user'=> $user
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json([
            'message' => 'Success',
            'user'=> $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'=> 'required|string',
            'email'=> 'required|string',
        ]);
        try {
            $user->update([
                'name'=> $request->name,
                'email'=> $request->email,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th
            ],500);
        }
        return response()->json([
            'message' => 'User Updated Successfully',
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'message' => 'User Deleted Successfully',
        ]);
    }
}
