<?php

namespace App\Livewire\Homepage;

use Livewire\Component;
use App\Models\Album;
use Illuminate\Support\Facades\Cache;

class AlbumsComp extends Component
{
    public $albums;

    public function mount()
    {
        $this->albums = Cache::remember('albums_comp', 60, function () {
            return Album::with('images')->latest()->limit(6)->get();
        });
    }

    public function render()
    {
        return view('livewire.homepage.albums-comp');
    }
}
