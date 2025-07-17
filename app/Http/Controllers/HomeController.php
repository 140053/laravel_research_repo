<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ResearchPaper;
use App\Models\Tag;


class HomeController extends Controller
{
    //
    public function index()
    {
        $tag = Tag::query()->get();

        $papers = ResearchPaper::query()
            ->where('status', true)
            ->latest() // optional: orders by created_at
            ->limit(6)
            ->get();   // ✅ Execute the query

        return view('welcome', compact('papers', 'tag'));
    }

    public function about(){
        return view('about');
    }
}
