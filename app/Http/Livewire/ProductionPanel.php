<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\SignalBit\MasterPlan;

class ProductionPanel extends Component
{
    public $orderInfo;
    public $orderWsDetails;

    public $selectedColor;

    public $panels = true;
    public $rft = false;
    public $defect = false;
    public $defectHistory = false;
    public $reject = false;
    public $rework = false;

    public function mount()
    {
        $this->orderInfo = $this->orderInfo;
        $this->orderWsDetails = $this->orderWsDetails;
        $this->selectedColor = $this->orderWsDetails[0]->color;
    }

    public function toRft() {
        $this->panels = false;
        $this->rft = !($this->rft);
    }

    public function toDefect() {
        $this->panels = false;
        $this->defect = !($this->defect);
    }

    public function toDefectHistory() {
        $this->panels = false;
        $this->defectHistory = !($this->defectHistory);
    }

    public function toReject() {
        $this->panels = false;
        $this->reject = !($this->reject);
    }

    public function toRework() {
        $this->panels = false;
        $this->rework = !($this->rework);
    }

    public function toProductionPanel() {
        $this->panels = true;
        $this->rft = false;
        $this->defect = false;
        $this->defectHistory = false;
        $this->reject = false;
        $this->rework = false;
    }

    public function render()
    {
        $orderWsDetailSizes = MasterPlan::selectRaw("
            DISTINCT master_plan.id_ws, master_plan.tgl_plan, mastersupplier.supplier, act_costing.styleno, so_det.styleno_prod, so.qty,
            master_plan.id as id,
            master_plan.tgl_plan as plan_date,
            act_costing.kpno as ws_number,
            mastersupplier.supplier as buyer_name,
            act_costing.styleno as style_name,
            so_det.styleno_prod as reff_number,
            so_det.color as color,
            so_det.size as size,
            so.qty as qty_order
        ")
        ->leftJoin('act_costing', 'act_costing.id', '=', 'master_plan.id_ws')
        ->leftJoin('so', 'so.id_cost', '=', 'act_costing.id')
        ->leftJoin('so_det', 'so_det.id_so', '=', 'so.id')
        ->leftJoin('mastersupplier', 'mastersupplier.id_supplier', '=', 'act_costing.id_buyer')
        ->leftJoin('master_size_new', 'master_size_new.size', '=', 'so_det.size')
        ->where('master_plan.sewing_line', Auth::user()->username)->where('act_costing.kpno', $this->orderInfo->ws_number)
        ->where('so_det.color', $this->selectedColor)
        ->get();

        return view('livewire.production-panel', [
            'orderWsDetails' => $this->orderWsDetails,
            'orderWsDetailSizes' => $orderWsDetailSizes,
            'panels' => $this->panels,
            'rft' => $this->rft,
            'defect' => $this->defect,
            'defectHistory' => $this->defectHistory,
            'reject' => $this->reject,
            'rework' => $this->rework,
        ]);
    }
}
