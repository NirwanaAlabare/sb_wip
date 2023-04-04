<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProductionPanel extends Component
{
    public $order;

    public function render()
    {
        return view('livewire.production-panel');
    }
}
