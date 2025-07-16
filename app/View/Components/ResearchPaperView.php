<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use App\Models\ResearchPaper;

class ResearchPaperView extends Component
{

    public $paper;

    /**
     * Create a new component instance.
     */
     public function __construct(ResearchPaper $paper)
    {
        $this->paper = $paper;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.research-paper-view');
    }
}
