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
                DISTINCT master_plan.id_ws, master_plan.tgl_plan, mastersupplier.supplier, act_costing.styleno, masterproduct.product_group, masterproduct.product_item, so_det.styleno_prod, so.qty,
                master_plan.id as id,
                master_plan.tgl_plan as plan_date,
                act_costing.kpno as ws_number,
                mastersupplier.supplier as buyer_name,
                act_costing.styleno as style_name,
                CONCAT(masterproduct.product_group, ' - ', masterproduct.product_item) as product_type,
                so_det.styleno_prod as reff_number,
                so.qty as qty_order
            ")
            ->leftJoin('act_costing', 'act_costing.id', '=', 'master_plan.id_ws')
            ->leftJoin('so', 'so.id_cost', '=', 'act_costing.id')
            ->leftJoin('so_det', 'so_det.id_so', '=', 'so.id')
            ->leftJoin('mastersupplier', 'mastersupplier.id_supplier', '=', 'act_costing.id_buyer')
            ->leftJoin('master_size_new', 'master_size_new.size', '=', 'so_det.size')
            ->leftJoin('masterproduct', 'masterproduct.id', '=', 'act_costing.id_product')
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
