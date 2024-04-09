<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $group = Group::with('users')->get();
        return response()->json([
            'status'=> 'success',
            'group'=> $group,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string',
            'category'=> 'required|string',
        ]);
        try {
            $group = Group::create([
                'name'=> $request->name,
                'category'=> $request->category,
            ]);
            $group->users()->attach($request->user_id);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th
            ],500);
        }
        return response()->json([
            'message' => 'Group Created Successfully',
            'group'=> $group
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        return response()->json([
            'message' => 'Success',
            'group'=> $group
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name'=> 'required|string',
            'category'=> 'required|string',
        ]);
        try {
            $group->update([
                'name'=> $request->name,
                'category'=> $request->category,
            ]);
            
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th
            ],500);
        }
        return response()->json([
            'message' => 'group Updated Successfully',
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }
}
