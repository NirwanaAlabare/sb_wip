<?php

namespace App\Http\Livewire;

use App\Models\SignalBit\MasterPlan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderList extends Component
{
    public $search = '';

    public function render()
    {
        $orders = MasterPlan::selectRaw("
                DISTINCT act_costing.kpno, master_plan.tgl_plan, mastersupplier.supplier, act_costing.styleno, so.qty,
                master_plan.id as id,
                master_plan.tgl_plan as plan_date,
                act_costing.kpno as ws_number,
                mastersupplier.supplier as buyer_name,
                act_costing.styleno as style_name,
                so.qty as qty_order
            ")
            ->leftJoin('so_det', 'so_det.id', '=', 'master_plan.id_so_det')
            ->leftJoin('so', 'so.id', '=', 'so_det.id_so')
            ->leftJoin('act_costing', 'act_costing.id', '=', 'so.id_cost')
            ->leftJoin('mastersupplier', 'mastersupplier.id_supplier', '=', 'act_costing.id_buyer')
            ->where('master_plan.sewing_line', Auth::user()->username)
            ->where('so_det.cancel', 'N')
            ->whereRaw("
                (
                    act_costing.kpno LIKE '%".$this->search."%'
                    OR
                    mastersupplier.supplier LIKE '%".$this->search."%'
                    OR
                    act_costing.styleno LIKE '%".$this->search."%'
                )
            ")
            ->orderBy('master_plan.tgl_plan','DESC')
            ->get();

        return view('livewire.order-list', ['orders' => $orders]);
    }
}
