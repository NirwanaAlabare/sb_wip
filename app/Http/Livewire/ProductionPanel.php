<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SignalBit\MasterPlan;
use App\Models\SignalBit\Rft;
use App\Models\SignalBit\Defect;
use App\Models\SignalBit\DefectType;
use App\Models\SignalBit\DefectArea;
use App\Models\SignalBit\Reject;
use App\Models\SignalBit\Rework;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

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

    // Undo
    public $undoType;
    public $undoQty;
    public $undoSize;
    public $undoDefectType;
    public $undoDefectArea;

    // Rules
    protected $rules = [
        'undoType' => 'required',
        'undoQty' => 'required|numeric|min:1',
        'undoSize' => 'required',
    ];

    protected $messages = [
        'undoType.required' => 'Terjadi kesalahan, tipe undo output tidak terbaca.',
        'undoQty.required' => 'Harap tentukan kuantitas undo output.',
        'undoQty.numeric' => 'Harap isi kuantitas undo output dengan angka.',
        'undoQty.min' => 'Kuantitas undo output tidak bisa kurang dari 1.',
        'undoSize.required' => 'Harap tentukan ukuran undo output.',
    ];

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
        'preSubmitUndo' => 'preSubmitUndo',
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
        $this->undoType = "";
        $this->undoQty = 1;
        $this->undoSize = "";
        $this->undoDefectType = "";
        $this->undoDefectArea = "";
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

    public function preSubmitUndo($undoType)
    {
        $this->undoType = $undoType;
        $this->emit('showModal', 'undo');
    }

    public function submitUndo()
    {
        $validatedData = $this->validate();

        $size = DB::select(DB::raw("SELECT * FROM so_det WHERE id = '".$this->undoSize."'"));
        $defectType = DefectType::select('defect_type')->find($this->undoDefectType);
        $defectArea = DefectArea::select('defect_area')->find($this->undoDefectArea);

        switch ($this->undoType) {
            case 'rft' :
                // Undo RFT
                $deleteRft = Rft::where('master_plan_id', $this->orderInfo->id)->
                    where('so_det_id', $this->undoSize)->
                    where('status', 'NORMAL')->
                    orderBy('updated_at', 'DESC')->
                    orderBy('created_at', 'DESC')->
                    take($this->undoQty)->
                    delete();

                if ($deleteRft)  {
                    $this->emit('alert', 'success', 'Output RFT dengan ukuran '.$size[0]->size.' berhasil di UNDO sebanyak '.$deleteRft.' kali.');
                } else {
                    $this->emit('alert', 'error', 'Output RFT dengan ukuran '.$size[0]->size.' gagal di UNDO.');
                }

                break;
            case 'defect' :
                // Undo DEFECT
                $defectQuery = Defect::selectRaw('output_defects.id as defect_id')->
                    leftJoin('output_defect_areas', 'output_defect_areas.id', '=', 'output_defects.defect_area_id')->
                    leftJoin('output_defect_types', 'output_defect_types.id', '=', 'output_defects.defect_type_id')->
                    where('master_plan_id', $this->orderInfo->id)->
                    where('so_det_id', $this->undoSize)->
                    where('defect_status', 'defect');
                if ($this->undoDefectType) {
                    $defectQuery->where('output_defects.defect_type_id', $this->undoDefectType);
                };
                if ($this->undoDefectArea) {
                    $defectQuery->where('output_defects.defect_area_id', $this->undoDefectArea);
                };
                $getDefects = $defectQuery->orderBy('output_defects.updated_at', 'DESC')->
                    orderBy('output_defects.created_at', 'DESC')->
                    take($this->undoQty)->
                    get()->toArray();

                $deleteDefect = Defect::destroy($getDefects);

                $defectTypeText = $defectType ? ' dengan defect type = '.$defectType->defect_type : '';
                $defectAreaText = $defectArea ? 'dengan defect area = '.$defectArea->defect_area.' ' : '';

                if ($deleteDefect) {
                    $this->emit('alert', 'success', 'Output DEFECT dengan ukuran '.$size[0]->size.''.$defectTypeText.' '.$defectAreaText.'berhasil di UNDO sebanyak '.$deleteDefect.' kali.');
                } else {
                    $this->emit('alert', 'error', 'Output DEFECT dengan ukuran '.$size[0]->size.''.$defectTypeText.' '.$defectAreaText.'gagal di UNDO.');
                }

                break;
            case 'reject' :
                // Undo REJECT
                $deleteReject = Reject::where('master_plan_id', $this->orderInfo->id)->
                    where('so_det_id', $this->undoSize)->
                    orderBy('updated_at', 'DESC')->
                    orderBy('created_at', 'DESC')->
                    take($this->undoQty)->
                    delete();

                if ($deleteReject) {
                    $this->emit('alert', 'success', 'Output REJECT dengan ukuran '.$size[0]->size.' berhasil di UNDO sebanyak '.$deleteReject.' kali.');
                } else {
                    $this->emit('alert', 'error', 'Output REJECT dengan ukuran '.$size[0]->size.' gagal di UNDO.');
                }

                break;
            case 'rework' :
                // Undo REWORK
                $defectQuery = Defect::selectRaw('output_defects.id as defect_id, output_defects.*, output_defect_areas.defect_type_id')->
                    leftJoin('output_defect_areas', 'output_defect_areas.id', '=', 'output_defects.defect_area_id')->
                    leftJoin('output_defect_types', 'output_defect_types.id', '=', 'output_defects.defect_type_id')->
                    where('master_plan_id', $this->orderInfo->id)->
                    where('so_det_id', $this->undoSize)->
                    where('defect_status', 'reworked');
                if ($this->undoDefectType) {
                    $defectQuery->where('output_defects.defect_type_id', $this->undoDefectType);
                }
                if ($this->undoDefectArea) {
                    $defectQuery->where('output_defects.defect_area_id', $this->undoDefectArea);
                }
                $getDefects = $defectQuery->orderBy('output_defects.updated_at', 'DESC')->
                    orderBy('output_defects.created_at', 'DESC')->
                    take($this->undoQty)->
                    get();

                // update defect & delete rework
                foreach ($getDefects as $defect) {
                    Defect::where('id', $defect->defect_id)->update(['defect_status' => 'defect']);
                    Rft::leftJoin('output_reworks', 'output_reworks.id', '=', 'output_rfts.rework_id')->where('output_reworks.defect_id', $defect->defect_id)->delete();
                    Rework::where('defect_id', $defect->defect_id)->delete();
                }

                $defectTypeText = $defectType ? ' dengan defect type = '.$defectType->defect_type : '';
                $defectAreaText = $defectArea ? 'dengan defect area = '.$defectArea->defect_area.' ' : '';

                if ($getDefects->count() > 0) {
                    $this->emit('alert', 'success', 'Output REWORK dengan ukuran '.$size[0]->size.''.$defectTypeText.' '.$defectAreaText.'berhasil di UNDO sebanyak '.$getDefects->count().' kali.');
                } else {
                    $this->emit('alert', 'error', 'Output REWORK dengan ukuran '.$size[0]->size.''.$defectTypeText.' '.$defectAreaText.'gagal di UNDO.');
                }

                break;
        }
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

        // Defect
        $undoDefectTypes = DefectType::all();
        $undoDefectAreas = DefectArea::all();

        return view('livewire.production-panel', ['undoDefectTypes' => $undoDefectTypes, 'undoDefectAreas' => $undoDefectAreas]);
    }

    public function dehydrate()
    {
        $this->resetValidation();
        $this->resetErrorBag();
    }
}
