<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Albums;
use Illuminate\Support\Facades\Storage;

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
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'captions.*' => 'nullable|string|max:255',
        ]);

        $images = $request->file('images');
        $captions = $request->input('captions');

        foreach ($images as $index => $image) {
            $path = $image->store('public/gallery');

            Image::create([
                'album_id' => $album->id,
                'path' => str_replace('public/', 'storage/', $path),
                'caption' => $captions[$index] ?? null,
            ]);
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Images uploaded successfully.');
    }


}
