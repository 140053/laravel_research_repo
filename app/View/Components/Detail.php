<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Detail extends Component
{
    public string $label;
    public mixed $value;
    public ?string $lclass = null;

    /**
     * Create a new component instance.
     */
    public function __construct(string $label, mixed $value = null , ?string $lclass = null)
    {
        $this->label = $label;
        $this->value = $value;
        $this->lclass = $lclass;
    }
   
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.detail');
    }
}
