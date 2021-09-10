<?php

namespace App\Http\Livewire\Website;

use App\Models\Website;
use Livewire\Component;

class Edit extends Component
{
    public Website $website;

    protected $rules = [
        'website.name' => 'required|max:255',
        'website.url' => 'required|url|max:255',
    ];

    public function render()
    {
        return view('livewire.website.edit');
    }

    public function save()
    {
        $this->validate();

        $this->website->save();

        return redirect()->route('website.index');
    }
}
