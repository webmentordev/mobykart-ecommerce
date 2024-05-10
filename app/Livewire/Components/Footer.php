<?php

namespace App\Livewire\Components;

use App\Models\Category;
use Livewire\Component;

class Footer extends Component
{
    public function render()
    {
        return view('livewire.components.footer', [
            'categories' => Category::orderBy('title', 'asc')->limit(8)->get()
        ]);
    }
}
