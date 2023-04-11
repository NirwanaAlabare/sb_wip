<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Session\SessionManager;

class Defect extends Component
{
    public $orderWsDetailSizes;
    public $outputInput;
    public $sizeInput;
    public $defectType;
    public $defectArea;

    public function mount(SessionManager $session, $orderWsDetailSizes)
    {
        $this->orderWsDetailSizes = $orderWsDetailSizes;
        $session->put('orderWsDetailSizes', $orderWsDetailSizes);
        $this->outputInput = 1;
        $this->sizeInput = "";
        $this->defectType = "";
        $this->defectArea = "";
    }

    public function outputIncrement()
    {
        $this->outputInput++;
    }

    public function outputDecrement()
    {
        if (($this->outputInput-1) < 1) {
            $this->emit('alert', 'warning', "Output can't be less than 1");
        } else {
            $this->outputInput--;
        }
    }

    public function setSizeInput($size)
    {
        $this->sizeInput = $size;
    }

    public function submitInput()
    {
        $this->outputInput;
        $this->sizeInput;
    }

    public function render(SessionManager $session)
    {
        $this->orderWsDetailSizes = $session->get('orderWsDetailSizes', $this->orderWsDetailSizes);

        return view('livewire.defect', ['orderWsDetailSizes' => $this->orderWsDetailSizes]);
    }
}
