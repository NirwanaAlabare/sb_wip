<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SignalBit\MasterPlan;
use App\Models\SignalBit\Rft;
use App\Models\SignalBit\Defect;
use App\Models\SignalBit\Reject;
use App\Models\SignalBit\Rework;
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
    public $selectedSize;

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
        'toRework' => 'toRework',
        'countRft' => 'countRft',
        'countDefect' => 'countDefect',
        'countReject' => 'countReject',
        'countRework' => 'countRework',
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
        $this->selectedSize = 'all';
        $this->panels = true;
        $this->rft = false;
        $this->defect = false;
        $this->defectHistory = false;
        $this->reject = false;
        $this->rework = false;
        $this->outputRft = 0;
        $this->outputDefect = 0;
        $this->outputReject = 0;
        $this->outputRework = 0;
        $this->outputFiltered = 0;
    }

    public function toRft()
    {
        $this->panels = false;
        $this->rft = !($this->rft);
        $this->emit('toInputPanel', 'rft');
    }

    public function toDefect()
    {
        $this->panels = false;
        $this->defect = !($this->defect);
        $this->emit('toInputPanel', 'defect');
    }

    public function toDefectHistory()
    {
        $this->panels = false;
        $this->defectHistory = !($this->defectHistory);
        $this->emit('toInputPanel', 'defect');
    }

    public function toReject()
    {
        $this->panels = false;
        $this->reject = !($this->reject);
        $this->emit('toInputPanel', 'reject');
    }

    public function toRework()
    {
        $this->panels = false;
        $this->rework = !($this->rework);
        $this->emit('toInputPanel', 'rework');
    }

    public function toProductionPanel()
    {
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
        // Keep these data with session
        $this->orderInfo = $session->get('orderInfo');
        $this->orderWsDetails = $session->get('orderWsDetails');

        // Get size data by color
        $this->orderWsDetailSizes = MasterPlan::selectRaw("
            MIN(so_det.id) as so_det_id,
            so_det.size as size
        ")
        ->leftJoin('act_costing', 'act_costing.id', '=', 'master_plan.id_ws')
        ->leftJoin('so', 'so.id_cost', '=', 'act_costing.id')
        ->leftJoin('so_det', 'so_det.id_so', '=', 'so.id')
        ->leftJoin('mastersupplier', 'mastersupplier.id_supplier', '=', 'act_costing.id_buyer')
        ->where('master_plan.sewing_line', Auth::user()->username)
        ->where('act_costing.kpno', $this->orderInfo->ws_number)
        ->where('so_det.color', $this->selectedColor)
        ->groupBy('so_det.size')
        ->orderBy('so_det_id')
        ->get();

        // Get total output
        $this->outputRft = Rft::
            where('master_plan_id', $this->orderInfo->id)->
            count();
        $this->outputDefect = Defect::
            where('master_plan_id', $this->orderInfo->id)->
            where('defect_status', 'defect')->
            count();
        $this->outputReject = Reject::
            where('master_plan_id', $this->orderInfo->id)->
            count();
        $this->outputRework = Defect::
            where('master_plan_id', $this->orderInfo->id)->
            where('defect_status', 'reworked')->
            count();
        $sqlFiltered = Rft::select('id')->where('master_plan_id', $this->orderInfo->id);
        $this->outputFiltered = $this->selectedSize == 'all' ? $sqlFiltered->count() : $sqlFiltered->where('so_det_id', $this->selectedSize)->count();

        return view('livewire.production-panel');
    }
}
