<?php

namespace App\Http\Livewire\Website;

use App\Models\Website;
use Livewire\Component;

class Index extends Component
{
    public function getWebsitesProperty()
    {
        return Website::all();
    }

    public function render()
    {
        return view('livewire.website.index');
    }
}
