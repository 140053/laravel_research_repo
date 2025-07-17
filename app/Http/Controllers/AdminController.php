<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResearchPaper;

class AdminController extends Controller
{
    //
    public function index()
    {
         // Count for status true and false
         $approvedCount = ResearchPaper::where('status', true)->count();
         $pendingCount = ResearchPaper::where('status', false)->count();

        return view('admin.index', compact('approvedCount','pendingCount'));
    }


    
}
