<?php

namespace App\Livewire\Homepage;

use Livewire\Component;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;

class Tags extends Component
{
    public $tags;

    public function mount()
    {
        $this->tags = Cache::remember('tags_comp', 60, function () {
            return Tag::all();
        });
    }

    public function render()
    {
        return view('livewire.homepage.tags');
    }
}
