<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AccordionWithLink extends Component
{
    public string $label;
    public string $content;
    public string $link;
    /**
     * Create a new component instance.
     */

    public function __construct(string $label, string $content, string $link)
    {
        $this->label = $label;
        $this->content = $content;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.accordion-with-link');
    }
}
