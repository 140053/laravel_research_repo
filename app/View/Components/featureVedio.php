<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class featureVedio extends Component
{
    /**
     * Create a new component instance.
     */

     public $vedio;
     

    
    public function __construct($vedio)
    {
        $this->vedio = $vedio;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.feature-vedio');
    }
}
