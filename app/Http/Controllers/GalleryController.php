<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $galleries = Gallery::with('user')->latest()->paginate(12);
        } else {
            $galleries = Gallery::with('user')->whereHas('user', function($q) {
                $q->where('role', 'manager');
            })->latest()->paginate(12);
        }
        
        // Get feedbacks for the view
        $feedbacks = Feedback::with('user')->latest()->paginate(10);
        
        return view('gallery.index', compact('galleries', 'feedbacks'));
    }

    public function create()
    {
        return view('gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('gallery.index')->with('success', 'Image uploaded successfully!');
    }

    public function destroy(Gallery $gallery)
    {
        // Delete the image file
        Storage::disk('public')->delete($gallery->image_path);
        
        // Delete the database record
        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Image deleted successfully!');
    }
}