<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Session\SessionManager;
use App\Models\SignalBit\Defect;

class DefectHistory extends Component
{
    public $orderWsDetailSizes;
    public $defects;

    public function mount(SessionManager $session, $orderWsDetailSizes)
    {
        $this->orderWsDetailSizes = $orderWsDetailSizes;
        $session->put('orderWsDetailSizes', $orderWsDetailSizes);
    }

    public function render(SessionManager $session)
    {
        $this->orderWsDetailSizes = $session->get('orderWsDetailSizes', $this->orderWsDetailSizes);
        $this->defects = Defect::selectRaw('output_defects.*, so_det.size as so_det_size')->leftJoin('so_det', 'so_det.id', '=', 'output_defects.so_det_id')->get();

        return view('livewire.defect-history');
    }
}
