<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Session\SessionManager;
use App\Models\SignalBit\Defect;
use App\Models\SignalBit\DefectType;
use App\Models\SignalBit\DefectArea;

class DefectHistory extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $orderInfo;
    public $orderWsDetailSizes;

    public $filterDefectSize;
    public $filterDefectType;
    public $filterDefectArea;
    public $filterDefectStatus;
    public $search;
    // public $defects;

    public function mount(SessionManager $session, $orderWsDetailSizes)
    {
        $this->orderWsDetailSizes = $orderWsDetailSizes;
        $session->put('orderWsDetailSizes', $orderWsDetailSizes);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render(SessionManager $session)
    {
        $this->orderInfo = $session->get('orderInfo', $this->orderInfo);
        $this->orderWsDetailSizes = $session->get('orderWsDetailSizes', $this->orderWsDetailSizes);
        $defectTypes = DefectType::get();
        $defectAreas = DefectArea::get();
        $defects = Defect::selectRaw('output_defects.*, so_det.size as so_det_size')->
            leftJoin('so_det', 'so_det.id', '=', 'output_defects.so_det_id')->
            leftJoin('output_defect_areas', 'output_defect_areas.id', '=', 'output_defects.defect_area_id')->
            leftJoin('output_defect_types', 'output_defect_types.id', '=', 'output_defect_areas.defect_type_id')->
            where('output_defects.master_plan_id', $this->orderInfo->id);

        if ($this->filterDefectSize != null && $this->filterDefectSize != 'all') {
            $defects->where('so_det.id', $this->filterDefectSize);
        }

        if ($this->filterDefectType != null && $this->filterDefectType != 'all') {
            $defects->where('output_defect_types.id', $this->filterDefectType);
        }

        if ($this->filterDefectArea != null && $this->filterDefectArea != 'all') {
            $defects->where('output_defect_areas.id', $this->filterDefectArea);
        }

        if ($this->filterDefectStatus != null && $this->filterDefectStatus != 'all') {
            $defects->where('output_defects.defect_status', $this->filterDefectStatus);
        }

        $filteredDefects = $defects->whereRaw("(
            output_defects.id LIKE '%".$this->search."%' OR
            so_det.size LIKE '%".$this->search."%' OR
            output_defect_areas.defect_area LIKE '%".$this->search."%' OR
            output_defect_types.defect_type LIKE '%".$this->search."%' OR
            output_defects.defect_status LIKE '%".$this->search."%'
        )")->paginate(10);

        return view('livewire.defect-history', ['defects' => $filteredDefects, 'defectTypes' => $defectTypes, 'defectAreas' => $defectAreas]);
    }
}
