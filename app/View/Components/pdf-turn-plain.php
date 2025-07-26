<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class pdf-turn-plain extends Component
{
    /**
     * Create a new component instance.
     */
    public $data;
    public string $src;
    public function __construct(string $src, $data)
    {
        $this->data = $data;
        $this->src = $src;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pdf-turn-plain');
    }
}
