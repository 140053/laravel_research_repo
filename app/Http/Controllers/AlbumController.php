<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Albums;

class AlbumController extends Controller
{
    public function create()
    {
        return view('admin.gallery.albums.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Albums::create($request->only('name', 'description'));

        return redirect()->route('admin.gallery.index')->with('success', 'Album created successfully.');
    }

    public function destroy(Albums $album)
    {
        $album->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Album deleted successfully.');
    }

}
