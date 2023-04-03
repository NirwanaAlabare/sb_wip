<?php

namespace App\Http\Livewire;

use App\Models\LineProduction;
use Livewire\Component;

class OrderList extends Component
{
    public $search = '';

    public function render()
    {
        $orders = LineProduction::where('line_id', session('user_id'))
        ->whereHas('order', function($q) {
            $q->where('ws_number', 'LIKE', '%'.$this->search.'%');
            $q->orWhere('buyer_name', 'LIKE', '%'.$this->search.'%');
            $q->orWhere('style_name', 'LIKE', '%'.$this->search.'%');
            $q->orWhere('product_type', 'LIKE', '%'.$this->search.'%');
        })
        ->get();

        return view('livewire.order-list', ['orders' => $orders]);
    }
}
