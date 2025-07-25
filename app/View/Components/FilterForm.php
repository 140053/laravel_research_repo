<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterForm extends Component
{

    public string $link;
    /**
     * Create a new component instance.
     */
    public function __construct(string $link)
    //public function __construct()
    {
        
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.filter-form');
    }
}
