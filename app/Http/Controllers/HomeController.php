<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ResearchPaper;
use App\Models\Tag;
use Illuminate\Support\Str; 


class HomeController extends Controller
{
    //
    public function index()
    {
        $tag = Tag::query()
            ->where('status', true)
            ->latest() // optional: orders by created_at
            ->limit(12)
            ->get();

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
        $limitedAuthors = array_slice($uniqueAuthors, 0, 10);

        // Pass the unique authors list to the view
        return view('authors', compact('uniqueAuthors'));
    }

}
