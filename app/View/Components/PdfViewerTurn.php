<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PdfViewerTurn extends Component
{
    public string $src;
    public  $paper;
    /**
     * Create a new component instance.
     */
    public function __construct(string $src,  $paper)
    {
        $this->src = $src;
        $this->paper = $paper;
    }
        
    

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pdf-viewer-turn');
    }
}
