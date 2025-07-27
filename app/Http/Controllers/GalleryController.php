<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Images;
use App\Models\Albums;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = Albums::with('images')->paginate(5);
        return view('admin.gallery.index', compact('albums'));
    }

    public function view(Albums $album)
    {
        $album = Albums::with('Images')->findOrFail($album->id);

        //dd($album);
        return view('admin.gallery.view', compact('album'));

    }


    public function create(Albums $album)
    {
        return view('admin.gallery.upload', compact('album'));
    }


/*
    public function store(Request $request, Albums $album)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
            'captions.*' => 'nullable|string|max:255',
        ]);

        $images = $request->file('images');
        $captions = $request->input('captions');

        foreach ($images as $index => $image) {
            $path = $image->store('gallery', 'public');
            Images::create([
                'albums_id' => $album->id,
                'image_path' => $path, // already correct: gallery/filename.jpg
                'caption' => $captions[$index] ?? null,
            ]);

            //dd($request);

        }

        return redirect()->route('admin.gallery.index')->with('success', 'Images uploaded successfully.');
    }
        */
    
    public function store(Request $request, Albums $album)
    {
        try {
            $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'captions.*' => 'nullable|string|max:255',
        ], [
            'images.*.max' => 'Each image must not exceed 5MB.',
        ]);

            $images = $request->file('images');
            $captions = $request->input('captions');

            foreach ($images as $index => $image) {
                $path = $image->store('gallery', 'public');
                Images::create([
                    'albums_id' => $album->id,
                    'image_path' => $path,
                    'caption' => $captions[$index] ?? null,
                ]);
            }

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Images uploaded successfully.']);
            }

            return redirect()->route('admin.gallery.index')->with('success', 'Images uploaded successfully.');
        } catch (\Throwable $e) {
            Log::error('Upload failed: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Upload failed.'], 500);
            }

            return back()->withErrors(['upload_error' => 'An error occurred while uploading.'])->withInput();
        }
    }

    public function destroy(Images $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }






}
