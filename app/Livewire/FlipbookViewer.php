<?php

namespace App\Livewire;

use Livewire\Component;

class FlipbookViewer extends Component
{
    public $paper;
    public $src;

    public function mount($paper, $src)
    {
        $this->paper = $paper;
        $this->src = $src;
    }

    public function render()
    {
        return view('livewire.flipbook-viewer');
    }
}
