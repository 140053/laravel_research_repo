<?php

namespace App\Http\Controllers;



use App\Models\ResearchPaper;
use App\Models\Tag;

use App\Models\Albums;
use App\Models\Images;
use App\Models\FeatureMaterial;

class HomeController extends Controller
{
    //
    public function index()
    {        
        return view('welcome');
    }

    public function about(){
        return view('about');
    }

    public function categories(){
        return view('categories');
    }

    public function feature(){
        //$brochure = FeatureMaterial::where('type', 'pdf')->latest()->first();
        $vedio = FeatureMaterial::where('type', 'link')
            ->whereNotNull('url')
            ->where('url', '!=', '')
            //->where('hidden', false)
            ->get(); //get all vedio with URL
        //dd($vedio);
        return view('feature', compact('vedio'));
    }

    public function gallery(){
        $albums = Albums::with('images')->get();
        //dd($albums);
        return view('gallery', compact('albums'));
    }

    public function viewAlbum(Albums $album)
    {
        $album = Albums::with('images')->findOrFail($album->id);
        return view('gallery.view', compact('album'));
    }

   

    /*
    public function author(){
        $papers = ResearchPaper::query()
            ->where('status', true)
            ->latest() // optional: orders by created_at
            ->limit(6)
            ->get();   // ✅ Execute the query

        return view('authors', compact('papers'));
    }
        */

    public function authorsIndex()
    {
        // Fetch all research papers, only selecting the 'authors' column to optimize performance
        $papers = ResearchPaper::select('authors')
            ->where('status', true)
            ->latest() // optional: orders by created_at
            ->limit(6)
            ->get();

        $allAuthors = [];

        foreach ($papers as $paper) {
            // Ensure the authors string is not null or empty
            if (!empty($paper->authors)) {
                // 1. Replace " and " with ", " to normalize the string for splitting
                // This handles cases where the last author is joined by "and"
                $normalizedString = str_replace(' and ', ', ', $paper->authors);

                // 2. Split the string by comma
                $individualAuthors = explode(',', $normalizedString);

                // 3. Trim whitespace from each element in the array
                $individualAuthors = array_map('trim', $individualAuthors);

                // 4. Remove any empty strings that might result from extra commas
                $individualAuthors = array_filter($individualAuthors);

                // Merge the current paper's authors into the main array
                $allAuthors = array_merge($allAuthors, $individualAuthors);
            }
        }

        // 5. Get unique authors to avoid duplicates if an author is on multiple papers
        $uniqueAuthors = array_unique($allAuthors);

        // 6. Re-index the array in case array_unique removed elements
        $uniqueAuthors = array_values($uniqueAuthors);

        // 7. (Optional) Sort authors alphabetically for a better display
        sort($uniqueAuthors);

        // 8. LIMIT the array to the first 10 authors
        $limitedAuthors = array_slice($uniqueAuthors, 0, 5);

        // Pass the unique authors list to the view
        return view('authors', compact('uniqueAuthors'));
    }

}
