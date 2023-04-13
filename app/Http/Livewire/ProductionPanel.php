<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SignalBit\MasterPlan;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Auth;

class ProductionPanel extends Component
{
    // Data
    public $orderInfo;
    public $orderWsDetails;
    public $orderWsDetailSizes;
    public $outputRft;
    public $outputDefect;
    public $outputReject;
    public $outputRework;
    public $outputFiltered;

    // Filter
    public $selectedColor;

    // Panel views
    public $panels;
    public $rft;
    public $defect;
    public $defectHistory;
    public $reject;
    public $rework;

    // Event listeners
    protected $listeners = [
        'toProductionPanel' => 'toProductionPanel',
        'toRft' => 'toRft',
        'toDefect' => 'toDefect',
        'toDefectHistory' => 'toDefectHistory',
        'toReject' => 'toReject',
        'toRework' => 'toRework'
    ];

    public function mount(SessionManager $session, $orderInfo, $orderWsDetails)
    {
        $this->orderInfo = $orderInfo;
        $this->orderWsDetails = $orderWsDetails;

        // Put data on session
        $session->put("orderInfo", $orderInfo);
        $session->put("orderWsDetails", $orderWsDetails);

        // Default value
        $this->selectedColor = $this->orderWsDetails[0]->color;
        $this->panels = true;
        $this->rft = false;
        $this->defect = false;
        $this->defectHistory = false;
        $this->reject = false;
        $this->rework = false;
    }

    public function toRft() {
        $this->panels = false;
        $this->rft = !($this->rft);
        $this->emit('toInputPanel', 'rft');
    }

    public function toDefect() {
        $this->panels = false;
        $this->defect = !($this->defect);
        $this->emit('toInputPanel', 'defect');
    }

    public function toDefectHistory() {
        $this->panels = false;
        $this->defectHistory = !($this->defectHistory);
        $this->emit('toInputPanel', 'defectHistory');
    }

    public function toReject() {
        $this->panels = false;
        $this->reject = !($this->reject);
        $this->emit('toInputPanel', 'reject');
    }

    public function toRework() {
        $this->panels = false;
        $this->rework = !($this->rework);
        $this->emit('toInputPanel', 'rework');
    }

    public function toProductionPanel() {
        $this->panels = true;
        $this->rft = false;
        $this->defect = false;
        $this->defectHistory = false;
        $this->reject = false;
        $this->rework = false;
        $this->emit('fromInputPanel');
    }

    public function render(SessionManager $session)
    {
        // Keep this data with session
        $this->orderInfo = $session->get('orderInfo', $this->orderInfo);
        $this->orderWsDetails = $session->get('orderWsDetails', $this->orderWsDetails);

        $this->orderWsDetailSizes = MasterPlan::selectRaw("
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
        ->where('master_plan.sewing_line', Auth::user()->username)
        ->where('act_costing.kpno', $this->orderInfo->ws_number)
        ->where('so_det.color', $this->selectedColor)
        ->get();

        $getRft;

        return view('livewire.production-panel', [
            // Data
            'orderInfo' => $this->orderInfo,
            'orderWsDetails' => $this->orderWsDetails,
            'orderWsDetailSizes' => $this->orderWsDetailSizes,

            // Panel views
            'panels' => $this->panels,
            'rft' => $this->rft,
            'defect' => $this->defect,
            'defectHistory' => $this->defectHistory,
            'reject' => $this->reject,
            'rework' => $this->rework,
        ]);
    }
}
