<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Line;

class OrderList extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire.order-list', ['items' => Line::where('name', 'LIKE', '%'.$this->search.'%')->get()]);
    }
}
