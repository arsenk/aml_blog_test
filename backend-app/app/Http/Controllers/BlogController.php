<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::with('user')
        ->latest()
            ->paginate(6);

        return response()->json($blogs);
    }

    public function show($id)
    {
        $blog = Blog::with('user')->find($id);

        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        return response()->json($blog);
    }

    public function store(StoreBlogRequest $request)
    {
        $validatedData = $request->validated();

        if (!$request->hasFile('image')) {
            return response()->json([
                'message' => 'Image is required',
            ], 400);
        }

        $imageUrl = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
            $imageUrl = url(Storage::url($imagePath));
        }

        $blog = Blog::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'image_url' => $imageUrl,
            'user_id' => Auth::id(),
        ]);

        return response()->json($blog, 201);
    }

    public function update(UpdateBlogRequest $request, string $id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        if ($blog->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validated();

        $blog->title = $validatedData['title'];
        $blog->content = $validatedData['content'];

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imagePath = $request->file('image')->store('public/images');
            $blog->image_url = url(Storage::url($imagePath));
        }

        $blog->save();

        return response()->json(['message' => 'Blog updated successfully', 'blog' => $blog], 200);
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        if ($blog->user_id !== Auth::id()) {
            return response()->json(['message' => 'You are not authorized to delete this blog'], 403);
        }

        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully'], 200);
    }
}
