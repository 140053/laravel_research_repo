<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResearchPaper;
use App\Models\User;
use App\Models\Album;

class AdminController extends Controller
{
    //
    public function index()
    {
         // Count for status true and false
         $approvedCount = ResearchPaper::where('status', true)->count();
         $pendingCount = ResearchPaper::where('status', false)->count();

         //album
        $album_count = Album::get()->count();

         //User
         $users = User::get()->count();

        return view('admin.index', compact('approvedCount','pendingCount', 'users', 'album_count'));
    }



}
