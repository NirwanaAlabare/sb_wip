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
        $this->outputInput = 1;
        $this->sizeInput = null;
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

    public function setSizeInput($size)
    {
        $this->sizeInput = $size;
    }

    public function preSubmitInput()
    {
        $this->validateOnly('outputInput');
        $this->validateOnly('sizeInput');

        $this->emit('showModal', 'defect');
    }

    public function submitInput()
    {
        $validatedData = $this->validate();

        $insertData = [];
        for ($i = 0; $i < $this->outputInput; $i++)
        {
            array_push($insertData, [
                'size' => $this->sizeInput,
                'jenis_defect' => $this->defectType,
                'area_defect' => $this->defectArea
            ]);
        }

        $this->emit('alert', 'success', $this->outputInput." output DEFECT berukuran ".$this->sizeInput." dengan jenis defect : ".$this->defectType." dan area defect : ".$this->defectArea." berhasil terekam.");

        $this->emit('hideModal', 'defect');

        // $insertDefect = Defect::insert($insertData);

        // if ($insertDefect) {
        //     $this->emit('alert', 'success', $this->outputInput." output berukuran ".$this->sizeInput." berhasil terekam.");
        // } else {
        //     $this->emit('alert', 'error', "Terjadi kesalahan. Output tidak berhasil direkam.");
        // }
    }

    public function render(SessionManager $session)
    {
        $this->orderWsDetailSizes = $session->get('orderWsDetailSizes', $this->orderWsDetailSizes);

        return view('livewire.defect', ['orderWsDetailSizes' => $this->orderWsDetailSizes]);
    }
}
