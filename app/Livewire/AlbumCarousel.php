<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Album;


class AlbumCarousel extends Component
{
    public $album;
    public $current = 0;
    protected $listeners = ['autoSlide'];


    public function mount(Album $album)
    {
        $this->album = $album->load('Images'); // Eager load images
    }

    public function next()
    {
        $this->current = ($this->current + 1) % count($this->album->Images);
    }

    public function prev()
    {
        $this->current = ($this->current - 1 + count($this->album->Images)) % count($this->album->Images);
    }

    public function goTo($index)
    {
        $this->current = $index;
    }

    public function render()
    {
        return view('livewire.album-carousel');
    }

    
    public function autoSlide()
    {
        $this->next();
    }
}