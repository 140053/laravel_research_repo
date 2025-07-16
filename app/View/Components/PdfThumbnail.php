<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PdfThumbnail extends Component
{
    public string $src;
    public string $id;

    public function __construct(string $src , string $id = 'pdf-thumbnail')
    {
        $this->src = $src;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pdf-thumbnail');
    }
}
