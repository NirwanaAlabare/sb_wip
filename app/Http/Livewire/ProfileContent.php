<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\SignalBit\Rft;
use App\Models\SignalBit\Defect;
use App\Models\SignalBit\Reject;
use App\Models\SignalBit\Rework;
use App\Models\SignalBit\MasterPlan;
use DB;

class ProfileContent extends Component
{
    public $dateFrom;
    public $dateTo;

    public function mount()
    {
        $this->dateFrom = $this->dateFrom ? $this->dateFrom : date('Y-m-d');
        $this->dateTo = $this->dateTo ? $this->dateTo : date('Y-m-d');
    }

    public function render()
    {
        $totalRft = Rft::select('output_rfts.*')->
            leftJoin('master_plan', 'master_plan.id', '=', 'output_rfts.master_plan_id')->
            where('master_plan.sewing_line', Auth::user()->username)->
            whereRaw("DATE(output_rfts.created_at) >= '".$this->dateFrom."'")->
            whereRaw("DATE(output_rfts.created_at) <= '".$this->dateTo."'")->
            count();
        $totalDefect = Defect::select('output_defects.*')->
            leftJoin('master_plan', 'master_plan.id', '=', 'output_defects.master_plan_id')->
            where('master_plan.sewing_line', Auth::user()->username)->
            whereRaw("DATE(output_defects.created_at) >= '".$this->dateFrom."'")->
            whereRaw("DATE(output_defects.created_at) <= '".$this->dateTo."'")->
            count();
        $totalReject = Reject::select('output_rejects.*')->
            leftJoin('master_plan', 'master_plan.id', '=', 'output_rejects.master_plan_id')->
            where('master_plan.sewing_line', Auth::user()->username)->
            whereRaw("DATE(output_rejects.created_at) >= '".$this->dateFrom."'")->
            whereRaw("DATE(output_rejects.created_at) <= '".$this->dateTo."'")->
            count();
        $totalRework = Rework::select('output_rework.*')->
            leftJoin('output_defects', 'output_defects.id', '=', 'output_reworks.defect_id')->
            leftJoin('master_plan', 'master_plan.id', '=', 'output_defects.master_plan_id')->
            where('master_plan.sewing_line', Auth::user()->username)->
            whereRaw("DATE(output_reworks.created_at) >= '".$this->dateFrom."'")->
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

        \Log::info($latestOutput);

        return view('livewire.profile-content', [
            'totalRft' => $totalRft,
            'totalDefect' => $totalDefect,
            'totalReject' => $totalReject,
            'totalRework' => $totalRework,
            'latestOutput' => $latestOutput
        ]);
    }
}
