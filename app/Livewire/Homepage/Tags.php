<?php

namespace App\Livewire\Homepage;

use Livewire\Component;
use App\Models\Tag;

class Tags extends Component
{

    public $tags;

    public function mount()
    {
        $this->tags = Tag::all();
    }

    public function render()
    {
        return view('livewire.homepage.tags');
    }
}
