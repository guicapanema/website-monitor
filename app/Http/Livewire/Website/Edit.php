<?php

namespace App\Http\Livewire\Website;

use App\Models\Website;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Edit extends Component
{
    public $website;

    protected $rules = [
        'website.name' => 'required|max:255',
        'website.url' => 'required|url|max:65535',
    ];

    public function mount(Website $website)
    {
        $this->website = $website;
    }

    public function render()
    {
        return view('livewire.website.edit');
    }

    public function save()
    {
        $this->validate();

        if (! $this->website->exists) {
            $this->website->user_id = Auth::user()->id;
            $this->website->enabled = true;
        }

        $this->website->save();

        return redirect()->route('website.index');
    }
}
