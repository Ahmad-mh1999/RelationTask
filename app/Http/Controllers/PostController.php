<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::with('users')->get();
        return response()->json([
            'status'=> 'success',
            'post'=> $post,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=> 'required|string',
            'content'=> 'required|string',
        ]);
        try {
            $post = Post::create([
                'title'=> $request->title,
                'content'=> $request->content,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th
            ],500);
        }
        return response()->json([
            'message' => 'Post Created Successfully',
            'post'=> $post
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json([
            'message' => 'Success',
            'post'=> $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'=> 'required|string',
            'content'=> 'required|string',
        ]);
        try {
            $post->update([
                'title'=> $request->title,
                'content'=> $request->content,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th
            ],500);
        }
        return response()->json([
            'message' => 'Post Updated Successfully',
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            'message' => 'Post Deleted Successfully',
        ]);
    }
}
