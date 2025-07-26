<?php

namespace App\Livewire\Homepage;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ResearchPaper;
use Illuminate\Support\Facades\Cache;

class RecentPapers extends Component
{
    use WithPagination;

    public function render()
    {
        $page = request()->get('page', 1);
        $papers = Cache::remember('recent_papers_page_' . $page, 60, function () {
            return ResearchPaper::with('tags')->where('status', true)->latest()->paginate(6);
        });
        return view('livewire.homepage.recent-papers', [
            'papers' => $papers,
        ]);
    }
}
