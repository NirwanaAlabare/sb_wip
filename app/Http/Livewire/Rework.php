<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Session\SessionManager;
use App\Models\SignalBit\Rft;
use App\Models\SignalBit\Defect;
use App\Models\SignalBit\Rework as ReworkModel;

class Rework extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $orderInfo;
    public $orderWsDetailSizes;
    public $searchDefect;
    public $searchRework;
    // public $defects;
    // public $reworks;

    protected $listeners = ['submitRework', 'cancelRework'];

    public function mount(SessionManager $session, $orderWsDetailSizes)
    {
        $this->orderWsDetailSizes = $orderWsDetailSizes;
        $session->put('orderWsDetailSizes', $orderWsDetailSizes);
    }

    public function updatingSearchDefect()
    {
        $this->resetPage('defectsPage');
    }

    public function updatingSearchRework()
    {
        $this->resetPage('reworksPage');
    }

    public function submitRework($defectId) {
        // add to rework
        $createRework = ReworkModel::create([
            "defect_id" => $defectId,
            "status" => "NORMAL"
        ]);

        // remove from defect
        $defect = Defect::where('id', $defectId);
        $getDefect = $defect->first();
        $updateDefect = $defect->update([
            "defect_status" => "reworked"
        ]);

        // add to rft
        $createRft = Rft::create([
            'master_plan_id' => $getDefect->master_plan_id,
            'so_det_id' => $getDefect->so_det_id,
            "status" => "NORMAL"
        ]);

        if ($createRework && $updateDefect && $createRft) {
            $this->emit('alert', 'success', "DEFECT dengan ID : ".$defectId." berhasil di REWORK.");
        } else {
            $this->emit('alert', 'error', "Terjadi kesalahan. DEFECT dengan ID : ".$defectId." tidak berhasil di REWORK.");
        }
    }

    public function cancelRework($reworkId, $defectId) {
        // delete from rework
        $deleteRework = ReworkModel::where('id', $reworkId)->delete();

        // add to defect
        $defect = Defect::where('id', $defectId);
        $getDefect = $defect->first();
        $updateDefect = $defect->update([
            "defect_status" => "defect"
        ]);

        // delete from rft
        $deleteRft = Rft::where('master_plan_id', $getDefect->master_plan_id)->
            where('so_det_id', $getDefect->so_det_id)->
            orderBy('id', 'desc')->
            limit(1)->
            delete();

        if ($deleteRework && $updateDefect && $deleteRft) {
            $this->emit('alert', 'success', "REWORK dengan REWORK ID : ".$reworkId." dan DEFECT ID : ".$defectId." berhasil di kembalikan ke DEFECT.");
        } else {
            $this->emit('alert', 'error', "Terjadi kesalahan. REWORK dengan REWORK ID : ".$reworkId." dan DEFECT ID : ".$defectId." tidak berhasil dikembalikan ke DEFECT.");
        }
    }

    public function render(SessionManager $session)
    {
        $this->orderInfo = $session->get('orderInfo', $this->orderInfo);
        $this->orderWsDetailSizes = $session->get('orderWsDetailSizes', $this->orderWsDetailSizes);
        $defects = Defect::selectRaw('output_defects.*, so_det.size as so_det_size')->
            leftJoin('so_det', 'so_det.id', '=', 'output_defects.so_det_id')->
            leftJoin('output_defect_areas', 'output_defect_areas.id', '=', 'output_defects.defect_area_id')->
            leftJoin('output_defect_types', 'output_defect_types.id', '=', 'output_defect_areas.defect_type_id')->
            where('output_defects.defect_status', 'defect')->
            where('output_defects.master_plan_id', $this->orderInfo->id)->
            whereRaw("(
                output_defects.id LIKE '%".$this->searchDefect."%' OR
                so_det.size LIKE '%".$this->searchDefect."%' OR
                output_defect_areas.defect_area LIKE '%".$this->searchDefect."%' OR
                output_defect_types.defect_type LIKE '%".$this->searchDefect."%' OR
                output_defects.defect_status LIKE '%".$this->searchDefect."%'
            )")->paginate(10, ['*'], 'defectsPage');
        $reworks = ReworkModel::selectRaw('output_reworks.*, so_det.size as so_det_size')->
            leftJoin('output_defects', 'output_defects.id', '=', 'output_reworks.defect_id')->
            leftJoin('output_defect_areas', 'output_defect_areas.id', '=', 'output_defects.defect_area_id')->
            leftJoin('output_defect_types', 'output_defect_types.id', '=', 'output_defect_areas.defect_type_id')->
            leftJoin('so_det', 'so_det.id', '=', 'output_defects.so_det_id')->
            where('output_defects.defect_status', 'reworked')->
            where('output_defects.master_plan_id', $this->orderInfo->id)->
            whereRaw("(
                output_reworks.id LIKE '%".$this->searchRework."%' OR
                output_defects.id LIKE '%".$this->searchRework."%' OR
                so_det.size LIKE '%".$this->searchRework."%' OR
                output_defect_areas.defect_area LIKE '%".$this->searchRework."%' OR
                output_defect_types.defect_type LIKE '%".$this->searchRework."%' OR
                output_defects.defect_status LIKE '%".$this->searchRework."%'
            )")->paginate(10, ['*'], 'reworksPage');

        return view('livewire.rework' , ['defects' => $defects, 'reworks' => $reworks]);
    }
}
