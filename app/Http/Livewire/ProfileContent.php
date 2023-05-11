<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\SignalBit\Rft;
use App\Models\SignalBit\Defect;
use App\Models\SignalBit\Reject;
use App\Models\SignalBit\Rework;
use App\Models\SignalBit\MasterPlan;
use Livewire\WithPagination;
use DB;

class ProfileContent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $masterPlan;
    public $dateFrom;
    public $dateTo;

    public function mount($masterPlan)
    {
        // dd($masterPlan);
        $this->masterPlan = $masterPlan ? $masterPlan->id : null;
        $this->dateFrom = $this->dateFrom ? $this->dateFrom : date('Y-m-d');
        $this->dateTo = $this->dateTo ? $this->dateTo : date('Y-m-d');
    }

    public function render()
    {
        $totalRftSql = Rft::select('output_rfts.*')->
            leftJoin('master_plan', 'master_plan.id', '=', 'output_rfts.master_plan_id')->
            where('master_plan.sewing_line', Auth::user()->username);
            if ($this->masterPlan) {
                $totalRftSql->where('master_plan.id', $this->masterPlan);
            }
        $totalRft = $totalRftSql->whereRaw("DATE(output_rfts.created_at) >= '".$this->dateFrom."'")->
            where("status", "NORMAL")->
            whereRaw("DATE(output_rfts.created_at) <= '".$this->dateTo."'")->
            count();

        $totalDefectSql = Defect::select('output_defects.*')->
            leftJoin('master_plan', 'master_plan.id', '=', 'output_defects.master_plan_id')->
            where('output_defects.defect_status', 'defect')->
            where('master_plan.sewing_line', Auth::user()->username)->
            where('output_defects.defect_status', 'defect');
            if ($this->masterPlan) {
                $totalDefectSql->where('master_plan.id', $this->masterPlan);
            }
        $totalDefect = $totalDefectSql->whereRaw("DATE(output_defects.created_at) >= '".$this->dateFrom."'")->
            whereRaw("DATE(output_defects.created_at) <= '".$this->dateTo."'")->
            count();

        $totalRejectSql = Reject::select('output_rejects.*')->
            leftJoin('master_plan', 'master_plan.id', '=', 'output_rejects.master_plan_id')->
            where('master_plan.sewing_line', Auth::user()->username);
            if ($this->masterPlan) {
                $totalRejectSql->where('master_plan.id', $this->masterPlan);
            }
        $totalReject = $totalRejectSql->whereRaw("DATE(output_rejects.created_at) >= '".$this->dateFrom."'")->
            whereRaw("DATE(output_rejects.created_at) <= '".$this->dateTo."'")->
            count();

        $totalReworkSql = Rework::select('output_reworks.*')->
            leftJoin('output_defects', 'output_defects.id', '=', 'output_reworks.defect_id')->
            leftJoin('master_plan', 'master_plan.id', '=', 'output_defects.master_plan_id')->
            where('master_plan.sewing_line', Auth::user()->username);
            if ($this->masterPlan) {
                $totalReworkSql->where('master_plan.id', $this->masterPlan);
            }
        $totalRework = $totalReworkSql->whereRaw("DATE(output_reworks.created_at) >= '".$this->dateFrom."'")->
            whereRaw("DATE(output_reworks.created_at) <= '".$this->dateTo."'")->
            count();

        // $latestOutput = MasterPlan::select('master_plan.*', 'output_rfts.created_at', 'output_defects.created_at', 'output_reworks.created_at', 'output_rejects.created_at')->
        //     leftJoin('output_rfts', 'output_rfts.master_plan_id', '=', 'master_plan.id')->
        //     leftJoin('output_defects', 'output_defects.master_plan_id', '=', 'master_plan.id')->
        //     leftJoin('output_rejects', 'output_rejects.master_plan_id', '=', 'master_plan.id')->
        //     leftJoin(DB::raw("(SELECT * FROM output_defects WHERE defect_status = 'reworked') as rework_defect"), 'rework_defect.master_plan_id', '=', 'master_plan.id')->
        //     where('master_plan.sewing_line', Auth::user()->username)->
        //     orderBy('output_rfts.created_at', 'desc')->
        //     limit('5')->
        //     get();

        $latestOutput = DB::select(DB::raw("
            SELECT output_rfts.created_at, output_rfts.updated_at FROM output_rfts
            LEFT JOIN master_plan ON master_plan.id = output_rfts.master_plan_id
            WHERE master_plan.sewing_line = '".Auth::user()->username."'
            UNION
            SELECT output_defects.created_at, output_defects.updated_at FROM output_defects
            LEFT JOIN master_plan ON master_plan.id = output_defects.master_plan_id
            WHERE master_plan.sewing_line = '".Auth::user()->username."'
            UNION
            SELECT output_rejects.created_at, output_rejects.updated_at FROM output_rejects
            LEFT JOIN master_plan ON master_plan.id = output_rejects.master_plan_id
            WHERE master_plan.sewing_line = '".Auth::user()->username."'
            UNION
            SELECT output_reworks.created_at, output_reworks.updated_at FROM output_reworks
            LEFT JOIN output_defects ON output_defects.id = output_reworks.defect_id
            LEFT JOIN master_plan ON master_plan.id = output_defects.master_plan_id
            WHERE master_plan.sewing_line = '".Auth::user()->username."'
            ORDER BY updated_at DESC, created_at DESC
            LIMIT 10
        "));

        $latestRfts = Rft::selectRaw('output_rfts.*, so_det.size as size')->
            leftJoin('master_plan', 'master_plan.id', '=', 'output_rfts.master_plan_id')->
            leftJoin('so_det', 'so_det.id', '=', 'output_rfts.so_det_id')->
            where('master_plan.sewing_line', Auth::user()->username)->
            whereRaw("DATE(output_rfts.created_at) >= '".$this->dateFrom."'")->
            whereRaw("DATE(output_rfts.created_at) <= '".$this->dateTo."'")->
            orderBy("output_rfts.updated_at", "desc")->
            orderBy("output_rfts.created_at", "desc")->
            paginate(5, ['*'], 'latestRftsPage');
        $latestDefects = Defect::selectRaw('output_defects.*, so_det.size as size')->
            leftJoin('master_plan', 'master_plan.id', '=', 'output_defects.master_plan_id')->
            leftJoin('so_det', 'so_det.id', '=', 'output_defects.so_det_id')->
            where('output_defects.defect_status', 'defect')->
            where('master_plan.sewing_line', Auth::user()->username)->
            whereRaw("DATE(output_defects.created_at) >= '".$this->dateFrom."'")->
            whereRaw("DATE(output_defects.created_at) <= '".$this->dateTo."'")->
            orderBy("output_defects.updated_at", "desc")->
            orderBy("output_defects.created_at", "desc")->
            paginate(5, ['*'], 'latestDefectsPage');
        $latestRejects = Reject::selectRaw('output_rejects.*, so_det.size as size')->
            leftJoin('master_plan', 'master_plan.id', '=', 'output_rejects.master_plan_id')->
            leftJoin('so_det', 'so_det.id', '=', 'output_rejects.so_det_id')->
            where('master_plan.sewing_line', Auth::user()->username)->
            whereRaw("DATE(output_rejects.created_at) >= '".$this->dateFrom."'")->
            whereRaw("DATE(output_rejects.created_at) <= '".$this->dateTo."'")->
            orderBy("output_rejects.updated_at", "desc")->
            orderBy("output_rejects.created_at", "desc")->
            paginate(5, ['*'], 'latestRejectsPage');
        $latestReworks = Rework::selectRaw('output_reworks.*, so_det.size as size')->
            leftJoin('output_defects', 'output_defects.id', '=', 'output_reworks.defect_id')->
            leftJoin('master_plan', 'master_plan.id', '=', 'output_defects.master_plan_id')->
            leftJoin('so_det', 'so_det.id', '=', 'output_defects.so_det_id')->
            where('master_plan.sewing_line', Auth::user()->username)->
            whereRaw("DATE(output_reworks.created_at) >= '".$this->dateFrom."'")->
            whereRaw("DATE(output_reworks.created_at) <= '".$this->dateTo."'")->
            orderBy("output_reworks.updated_at", "desc")->
            orderBy("output_reworks.created_at", "desc")->
            paginate(5, ['*'], 'latestReworksPage');

        return view('livewire.profile-content', [
            'totalRft' => $totalRft,
            'totalDefect' => $totalDefect,
            'totalReject' => $totalReject,
            'totalRework' => $totalRework,
            'latestOutput' => $latestOutput,
            'latestRfts' => $latestRfts,
            'latestDefects' => $latestDefects,
            'latestRejects' => $latestRejects,
            'latestReworks' => $latestReworks
        ]);
    }
}
