<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResearchPaper;
use App\Models\Albums;
use Jenssegers\Agent\Agent;




class DashboardController extends Controller
{
    //

    public function index(Request $request)
    {
        $query = ResearchPaper::query()
                ->where('status', true);

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

        //dd($papers);

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

     public function fulltext(string $id)     
    {
        $agent = new Agent();

        if ($agent->isDesktop()) {
            $device = 'desktop';
        } elseif ($agent->isTablet()) {
            $device = 'tablet';
        } elseif ($agent->isMobile()) {
            $device = 'mobile';
        } else {
            $device = 'unknown';
        }

        $paper = ResearchPaper::findOrFail($id);
        return view('dashboard.research.fulltext.index', compact('paper', 'device'));
    }


    public function view(Albums $album)
    {
        $album = Albums::with('Images')->findOrFail($album->id);

        //dd($album);
        return view('dashboard.gallery.view', compact('album'));

    }


    
}
