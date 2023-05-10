<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Session\SessionManager;
use App\Models\SignalBit\Rft as RftModel;
use App\Models\SignalBit\Rework;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class Rft extends Component
{
    public $orderInfo;
    public $orderWsDetailSizes;
    public $output;
    public $outputInput;
    public $sizeInput;
    public $sizeInputText;
    public $submitting;
    public $redundantData;

    protected $rules = [
        'outputInput' => 'required|numeric|min:1',
        'sizeInput' => 'required',
    ];

    protected $messages = [
        'outputInput.required' => 'Harap tentukan kuantitas output.',
        'outputInput.numeric' => 'Harap isi kuantitas output dengan angka.',
        'outputInput.min' => 'Kuantitas output tidak bisa kurang dari 1.',
        'sizeInput.required' => 'Harap tentukan ukuran output.',
    ];

    public function mount(SessionManager $session, $orderWsDetailSizes)
    {
        $this->orderWsDetailSizes = $orderWsDetailSizes;
        $session->put('orderWsDetailSizes', $orderWsDetailSizes);
        $this->output = 0;
        $this->outputInput = 1;
        $this->sizeInput = null;
        $this->sizeInputText = null;
        $this->submitting = false;
    }

    public function clearInput()
    {
        $this->outputInput = 1;
        $this->sizeInput = null;
        $this->sizeInputText = '';
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

    public function submitInput()
    {
        $validatedData = $this->validate();

        $insertData = [];
        for ($i = 0; $i < $this->outputInput; $i++)
        {
            array_push($insertData, [
                'master_plan_id' => $this->orderInfo->id,
                'so_det_id' => $this->sizeInput,
                'status' => 'NORMAL',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        $insertRft = RftModel::insert($insertData);

        if ($insertRft) {
            $this->emit('alert', 'success', $this->outputInput." output berukuran ".$this->sizeInputText." berhasil terekam.");
        } else {
            $this->emit('alert', 'error', "Terjadi kesalahan. Output tidak berhasil direkam.");
        }
    }

    public function deleteRedundant() {
        $redundantData = DB::select(DB::raw(
            "select defect_id, jml from (select defect_id, COUNT(defect_id) jml from (SELECT a.* from output_reworks a inner join output_defects c on c.id = a.defect_id inner join master_plan b on b.id = c.master_plan_id where b.sewing_line = '".Auth::user()->username."' and DATE_FORMAT(a.created_at, '%Y-%m-%d') = CURRENT_DATE() order by a.defect_id asc) a GROUP BY a.defect_id) a where a.jml > 1"
        ));

        foreach ($redundantData as $redundant) {
            $reworkData = Rework::where('defect_id', $redundant->defect_id)->limit(1)->first();
            Rework::where('id', $reworkData->id)->limit(1)->delete();
            RftModel::where('rework_id', $reworkData->id)->limit(1)->delete();
        }

        $this->emit('alert', 'success', 'Redundant deleted');
    }

    public function render(SessionManager $session)
    {
        $this->orderInfo = $session->get('orderInfo', $this->orderInfo);
        $this->orderWsDetailSizes = $session->get('orderWsDetailSizes', $this->orderWsDetailSizes);

        // Get total output
        $this->output = RftModel::
            where('master_plan_id', $this->orderInfo->id)->
            count();

        return view('livewire.rft');
    }

    public function dehydrate()
    {
        $this->resetValidation();
        $this->resetErrorBag();
    }
}
