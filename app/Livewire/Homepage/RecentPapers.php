<?php

namespace App\Livewire\Homepage;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ResearchPaper;

class RecentPapers extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.homepage.recent-papers', [
            'papers' => ResearchPaper::with('tags')->latest()->paginate(6),
        ]);
    }
}
