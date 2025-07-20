<?php

namespace App\Livewire\Homepage;

use Livewire\Component;
use App\Models\Albums;

class AlbumsComp extends Component
{

    public $albums;

    public function mount()
    {
        $this->albums = Albums::with('images')->latest()->limit(6)->get();
    }

    public function render()
    {
        return view('livewire.homepage.albums-comp');
    }
}
