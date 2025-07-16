<?php

namespace App\Http\Controllers;

use App\Models\ResearchPaper;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Imports\ResearchPaperImport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Collection;


class ResearchPaperController extends Controller
{
    //import 
    public function showImportForm()
    {
        return view('admin.research.import.index');
    }

    /**
     * Handle the import of research papers from a CSV file.
     */
    public function handleImport(Request $request)
    {
       // $request->validate([
        //    'csv_file' => 'required|mimes:csv,txt,xlsx|max:2048',
       // ]);

        $filePath = $request->input('file');

        if (!Storage::exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        //Excel::import(new ResearchPaperImport, $request->file('csv_file'));
        Excel::import(new ResearchPaperImport, Storage::path($filePath));

        return redirect()->route('admin.research.index')->with('success', 'Research papers imported successfully.');
    }

    /**
     * Preview the import data from a CSV file.
     */

    public function previewImport(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt,xlsx|max:2048',
        ]);

        $path = $request->file('csv_file')->store('temp');

        // Use Laravel Excel to read the file into collection
        $collection = Excel::toCollection(new ResearchPaperImport, $request->file('csv_file'))->first();

        return view('admin.research.import.preview', [
            'rows' => $collection,
            'file' => $path, // Save path for later confirmation
        ]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ResearchPaper::query();

        if( $request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('authors', 'like', '%' . $search . '%')
                  ->orWhere('editors', 'like', '%' . $search . '%')
                  ->orWhere('abstract', 'like', '%' . $search . '%')
                  ->orWhere('year', 'like', '%' . $search . '%')
                  ->orWhereHas('tags', function($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });

            });
        }

        $papers = $query->with('tags')->paginate(10);

        return view('admin.research.index', compact('papers'));
    }


    // view the detail of the research paper
    public function show(string $id)
    {
        $paper = ResearchPaper::with('tags')->findOrFail($id);
        //dd($paper);
        return view('admin.research.view', compact('paper'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.research.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'authors' => 'required|string',
            'editors' => 'nullable|string',
            'tm' => 'required|in:P,NP',
            'type' => 'required|in:Journal,Conference,Book,Thesis,Report',
            'publisher' => 'nullable|string',
            'isbn' => 'nullable|string',
            'abstract' => 'required|string',
            'year' => 'required|integer',
            'department' => 'required|string',
            'external_link' => 'nullable|url',
            'pdf' => 'nullable|file|mimes:pdf|max:20480',
            'tags' => 'nullable|string',
        ]);
        

        //dd($validated);

        $research = new ResearchPaper($validated);

        if ($request->hasFile('pdf')) {
            $research->pdf_path = $request->file('pdf')->store('pdfs', 'public');
        }

        $research->save();

        // Save tags
        if (!empty($request->tags)) {
            $tagNames = array_filter(array_map('trim', explode(',', $request->tags)));
            $tagIds = collect($tagNames)->map(fn($tag) => Tag::firstOrCreate(['name' => $tag])->id);
            $research->tags()->sync($tagIds);
        }

        return redirect()->route('admin.research.index')->with('success', 'Research paper added.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $paper = ResearchPaper::with('tags')->findOrFail($id);
        return view('admin.research.edit', compact('paper'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $research = ResearchPaper::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string',
            'authors' => 'required|string',
            'editors' => 'nullable|string',
            'tm' => 'required|in:P,NP',
            'type' => 'required|in:Journal,Conference,Book,Thesis,Report',
            'publisher' => 'nullable|string',
            'isbn' => 'nullable|string',
            'abstract' => 'required|string',
            'year' => 'required|integer',
            'department' => 'required|string',
            'external_link' => 'nullable|url',
            'pdf' => 'nullable|file|mimes:pdf|max:20480',
            'tags' => 'nullable|string',
        ]);
        

        $research->fill($validated);

        if ($request->hasFile('pdf')) {
            if ($research->pdf_path && Storage::disk('public')->exists($research->pdf_path)) {
                Storage::disk('public')->delete($research->pdf_path);
            }

            $research->pdf_path = $request->file('pdf')->store('pdfs', 'public');
        }

        $research->save();

        if (!empty($request->tags)) {
            $tagNames = array_filter(array_map('trim', explode(',', $request->tags)));
            $tagIds = collect($tagNames)->map(fn($tag) => Tag::firstOrCreate(['name' => $tag])->id);
            $research->tags()->sync($tagIds);
        } else {
            $research->tags()->detach();
        }

        return redirect()->route('admin.research.index')->with('success', 'Research paper updated.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paper = ResearchPaper::findOrFail($id);

        // Delete associated PDF
        if ($paper->pdf_path && Storage::disk('public')->exists($paper->pdf_path)) {
            Storage::disk('public')->delete($paper->pdf_path);
        }

        $paper->tags()->detach();
        $paper->delete();

        return redirect()->route('admin.research.index')->with('success', 'Research paper deleted.');
    }
}
