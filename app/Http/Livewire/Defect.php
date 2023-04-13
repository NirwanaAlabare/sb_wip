<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Session\SessionManager;
use App\Models\SignalBit\DefectType;
use App\Models\SignalBit\DefectArea;
use App\Models\SignalBit\Defect as DefectModel;
use Carbon\Carbon;

class Defect extends Component
{
    public $orderInfo;
    public $orderWsDetailSizes;
    public $output;
    public $outputInput;
    public $sizeInput;
    public $defectTypes;
    public $defectAreas;
    public $defectType;
    public $defectArea;

    protected $rules = [
        'outputInput' => 'required|numeric|min:1',
        'sizeInput' => 'required',
        'defectType' => 'required',
        'defectArea' => 'required',
    ];

    protected $messages = [
        'outputInput.required' => 'Harap tentukan kuantitas output.',
        'outputInput.numeric' => 'Harap isi kuantitas output dengan angka.',
        'outputInput.min' => 'Kuantitas output tidak bisa kurang dari 1.',
        'sizeInput.required' => 'Harap tentukan ukuran output.',
        'defectType.required' => 'Harap tentukan jenis defect.',
        'defectArea.required' => 'Harap tentukan area defect.',
    ];

    public function mount(SessionManager $session, $orderWsDetailSizes)
    {
        $this->orderWsDetailSizes = $orderWsDetailSizes;
        $session->put('orderWsDetailSizes', $orderWsDetailSizes);
        $this->output = 0;
        $this->outputInput = 1;
        $this->sizeInput = null;
        $this->defectType = null;
        $this->defectArea = null;
    }

    public function dehydrate()
    {
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function clearInput()
    {
        $this->outputInput = 1;
        $this->sizeInput = '';
    }

    public function outputIncrement()
    {
        $this->outputInput++;
    }

    public function outputDecrement()
    {
        if (($this->outputInput-1) < 1) {
            $this->emit('alert', 'warning', "Kuantitas output tidak bisa kurang dari 1.");
        } else {
            $this->outputInput--;
        }
    }

    public function setSizeInput($size, $sizeText)
    {
        $this->sizeInput = $size;
        $this->sizeInputText = $sizeText;
    }

    public function preSubmitInput()
    {
        $this->validateOnly('outputInput');
        $this->validateOnly('sizeInput');

        $this->emit('showModal', 'defect');
    }

    public function submitInput(SessionManager $session)
    {
        $validatedData = $this->validate();

        $insertData = [];
        for ($i = 0; $i < $this->outputInput; $i++)
        {
            array_push($insertData, [
                'master_plan_id' => $this->orderInfo->id,
                'so_det_id' => $this->sizeInput,
                'defect_area_id' => $this->defectArea,
                'status' => 'NORMAL',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        $insertDefect = DefectModel::insert($insertData);

        if ($insertDefect) {
            $type = DefectType::select('defect_type')->find($this->defectType);
            $area = DefectArea::select('defect_area')->find($this->defectArea);

            $this->emit('alert', 'success', $this->outputInput." output DEFECT berukuran ".$this->sizeInputText." dengan jenis defect : ".$type->defect_type." dan area defect : ".$area->defect_area." berhasil terekam.");
            $this->emit('hideModal', 'defect');
        } else {
            $this->emit('alert', 'error', "Terjadi kesalahan. Output tidak berhasil direkam.");
        }
    }

    public function render(SessionManager $session)
    {
        $this->orderInfo = $session->get('orderInfo', $this->orderInfo);
        $this->orderWsDetailSizes = $session->get('orderWsDetailSizes', $this->orderWsDetailSizes);

        // Get total output
        $this->output = DefectModel::
            where('master_plan_id', $this->orderInfo->id)->
            count();

        // Defect types
        $this->defectTypes = DefectType::all();

        // Defect areas
        $this->defectAreas = DefectArea::where('defect_type_id', $this->defectType)->get();

        return view('livewire.defect');
    }
}
