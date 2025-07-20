<?php

namespace App\Livewire\Homepage;

use Livewire\Component;

class SearchBar extends Component
{
    public $search = '';

    public function searchNow()
    {
        $url = auth()->user()->hasRole('admin')
            ? route('admin.research.index', ['search' => $this->search])
            : route('dashboard.research.index', ['search' => $this->search]);

        return redirect()->to($url);
    }
    
    public function render()
    {
        return view('livewire.homepage.search-bar');
    }
}
