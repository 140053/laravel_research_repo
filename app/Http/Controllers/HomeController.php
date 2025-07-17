<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ResearchPaper;

class HomeController extends Controller
{
    //
    public function index()
    {
        $papers = ResearchPaper::query()
            ->where('status', true)
            ->latest() // optional: orders by created_at
            ->limit(5)
            ->get();   // ✅ Execute the query

        return view('welcome', compact('papers'));
    }

    public function about(){
        return view('about');
    }
}
