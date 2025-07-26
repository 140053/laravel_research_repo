<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeatureMaterial;
use Illuminate\Support\Facades\Storage;

class FeatureMaterials extends Controller
{
    // Display a listing of the feature materials
    public function index()
    {
        $materials = FeatureMaterial::latest()->paginate(10);
        return view('admin.feature.index', compact('materials'));
    }

    // Show the form for creating a new feature material
    public function create()
    {
        return view('admin.feature.create');
    }

    // Store a newly created feature material in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,webp|max:10240',
            'type' => 'required|in:link,pdf,image,text',
            'hidden' => 'nullable|boolean',
            'location' => 'required|in:brochure,vedio,text',
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('feature_materials', 'public');
        }

        FeatureMaterial::create($validated);
        return redirect()->route('admin.feature.index')->with('success', 'Feature material created successfully.');
    }

    // Display the specified feature material
    public function show(FeatureMaterial $featureMaterial)
    {
        return view('admin.feature.show', compact('featureMaterial'));
    }

    // Show the form for editing the specified feature material
    public function edit(FeatureMaterial $featureMaterial)
    {
        return view('admin.feature.edit', compact('featureMaterial'));
    }

    // Update the specified feature material in storage
    public function update(Request $request, FeatureMaterial $featureMaterial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,webp|max:10240',
            'type' => 'required|in:link,pdf,image,text',
            'hidden' => 'nullable|boolean',
            'location' => 'required|in:brochure,vedio,text',
        ]);

        dd($validated);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('feature_materials', 'public');
        } else {
            // Keep the old file if not replaced
            $validated['file'] = $featureMaterial->file;
        }

        $featureMaterial->update($validated);
        return redirect()->route('admin.feature.index')->with('success', 'Feature material updated successfully.');
    }

    // Remove the specified feature material from storage
    public function destroy(FeatureMaterial $featureMaterial)
    {
        // Delete the file from storage if it exists
        if ($featureMaterial->file && Storage::disk('public')->exists($featureMaterial->file)) {
            Storage::disk('public')->delete($featureMaterial->file);
        }
        $featureMaterial->delete();
        return redirect()->route('admin.feature.index')->with('success', 'Feature material deleted successfully.');
    }
}
