<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class accordion extends Component
{
    public string $label;
    public string $content;
    /**
     * Create a new component instance.
     */

    public function __construct(string $label, string $content)
    {
        $this->label = $label;
        $this->content = $content;
    }
   

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.accordion');
    }
}
