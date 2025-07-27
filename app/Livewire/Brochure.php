<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FeatureMaterial;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Brochure extends Component
{
    public $brochure;
    public $isLoading = true;
    public $error = null;
    public $pdfUrl = null;

    protected $listeners = ['refreshBrochure'];

    public function mount()
    {
        $this->loadBrochure();
    }

    public function loadBrochure()
    {
        try {
            $this->isLoading = true;
            $this->error = null;

            $this->brochure = Cache::remember('brochure', 60, function () {
                return FeatureMaterial::where('location', 'brochure')
                    ->where('hidden', false)
                    ->where('type', 'pdf')
                    ->first();
            });

            if ($this->brochure) {
                // Use the new PDF route with CORS headers
                $filePath = $this->brochure->file;
                $filename = basename($filePath); // Extract just the filename
                $this->pdfUrl = route('pdf.serve', ['filename' => $filename]);
                
                Log::info('Brochure loaded successfully', [
                    'name' => $this->brochure->name,
                    'file' => $this->brochure->file,
                    'type' => $this->brochure->type,
                    'pdfUrl' => $this->pdfUrl
                ]);
            } else {
                $this->error = 'No brochure available at the moment.';
                Log::warning('No brochure found in database');
            }
        } catch (\Exception $e) {
            Log::error('Error loading brochure: ' . $e->getMessage());
            $this->error = 'Failed to load brochure. Please try again later.';
        } finally {
            $this->isLoading = false;
        }
    }

    public function refreshBrochure()
    {
        Cache::forget('brochure');
        $this->loadBrochure();
    }

    public function render()
    {
        return view('livewire.brochure');
    }
}
