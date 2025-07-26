<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FeatureMaterial;
use Illuminate\Support\Facades\Cache;

class FeatureVedio extends Component
{
    public $vedio;

    public function mount()
    {
        $this->loadVedio();
    }

    public function loadVedio()
    {
        $this->vedio = Cache::remember('vedio', 60, function () {
            return FeatureMaterial::where('type', 'link')->first();
        });
    }




    public function render()
    {
        return view('livewire.feature-vedio');
    }
}
