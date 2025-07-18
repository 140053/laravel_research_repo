<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Albums;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = Albums::with('images')->get();
        return view('admin.gallery.index', compact('albums'));
    }


    public function create(Albums $album)
    {
        return view('admin.gallery.upload', compact('album'));
    }



    public function store(Request $request, Albums $album)
    {
        $request->validate([
            'images.*' => 'required|image|max:5120', // max 5MB per image
        ]);

        foreach ($request->file('images') as $file) {
            $path = $file->store('gallery', 'public');
            $album->images()->create([
                'image_path' => $path,
            ]);
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Images uploaded successfully.');
    }


}
