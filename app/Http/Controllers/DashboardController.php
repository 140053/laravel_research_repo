<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResearchPaper;



class DashboardController extends Controller
{
    //

    public function index(Request $request)
    {
        $query = ResearchPaper::query();

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('department')) {
            $query->where('department', 'like', '%' . $request->department . '%');
        }

        if( $request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('authors', 'like', '%' . $search . '%')
                  ->orWhere('editors', 'like', '%' . $search . '%');
            });
        }

        $papers = $query->with('tags')->paginate(10);

       // dd($papers);

        //return view('admin.research.index', compact('papers'));
        return view('dashboard.index', compact('papers'));
    }

    public function show(string $id)
    {
        $paper = ResearchPaper::with('tags')->findOrFail($id);
        //dd($paper);
        return view('dashboard.research.view', compact('paper'));
        //return new \App\View\Components\ResearchPaperView($paper);
    }


    
}
