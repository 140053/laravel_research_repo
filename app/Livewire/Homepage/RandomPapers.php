<?php

namespace App\Livewire\Homepage;

use Livewire\Component;
use App\Models\ResearchPaper;

class RandomPapers extends Component
{

    public $papers;

    public function mount()
    {
        $this->papers = ResearchPaper::inRandomOrder()->limit(5)->get();
    }

    public function render()
    {
        return view('livewire.homepage.random-papers');
    }
}
