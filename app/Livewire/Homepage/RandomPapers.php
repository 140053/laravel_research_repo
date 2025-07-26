<?php

namespace App\Livewire\Homepage;

use Livewire\Component;
use App\Models\ResearchPaper;
use Illuminate\Support\Facades\Cache;

class RandomPapers extends Component
{
    public $papers;

    public function mount()
    {
        // Cache the random papers for 60 seconds
        $this->papers = Cache::remember('random_papers', 60, function () {
            return ResearchPaper::inRandomOrder()->where('status', true)->limit(5)->get();
        });
    }

    public function render()
    {
        return view('livewire.homepage.random-papers');
    }
}
