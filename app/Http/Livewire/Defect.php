<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Session\SessionManager;
use App\Models\SignalBit\MasterPlan;
use App\Models\SignalBit\ProductType;
use App\Models\SignalBit\DefectType;
use App\Models\SignalBit\DefectArea;
use App\Models\SignalBit\Defect as DefectModel;
use Carbon\Carbon;
use DB;

class Defect extends Component
{
    use WithFileUploads;

    public $orderInfo;
    public $orderWsDetailSizes;
    public $output;
    public $outputInput;
    public $sizeInput;
    public $sizeInputText;
    public $defectTypes;
    public $defectAreas;
    public $productTypes;
    public $defectType;
    public $defectArea;
    public $productType;
    public $defectTypeAdd;
    public $defectAreaAdd;
    public $productTypeAdd;
    public $productTypeImageAdd;
    public $defectAreaPositionX;
    public $defectAreaPositionY;

    protected $rules = [
        'outputInput' => 'required|numeric|min:1',
        'sizeInput' => 'required',
        // 'productType' => 'required',
        'defectType' => 'required',
        'defectArea' => 'required',
        'defectAreaPositionX' => 'required',
        'defectAreaPositionY' => 'required',
    ];

    protected $messages = [
        'outputInput.required' => 'Harap tentukan kuantitas output.',
        'outputInput.numeric' => 'Harap isi kuantitas output dengan angka.',
        'outputInput.min' => 'Kuantitas output tidak bisa kurang dari 1.',
        'sizeInput.required' => 'Harap tentukan ukuran output.',
        // 'productType.required' => 'Harap tentukan tipe produk.',
        'defectType.required' => 'Harap tentukan jenis defect.',
        'defectArea.required' => 'Harap tentukan area defect.',
        'defectAreaPositionX.required' => "Harap tentukan posisi defect area dengan mengklik tombol 'gambar' di samping 'select product type'.",
        'defectAreaPositionY.required' => "Harap tentukan posisi defect area dengan mengklik tombol 'gambar' di samping 'select product type'.",
    ];

    protected $listeners = [
        'setDefectAreaPosition' => 'setDefectAreaPosition',
        'updateWsDetailSizes' => 'updateWsDetailSizes',
        'updateOutput' => 'updateOutput',
        'updateOutputDefect' => 'updateOutput',
        'clearInput' => 'clearInput',
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
        $this->productType = null;
        $this->defectAreaPositionX = null;
        $this->defectAreaPositionY = null;
    }

    public function dehydrate()
    {
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function updateWsDetailSizes()
    {
        $this->outputInput = 1;
        $this->sizeInput = null;
        $this->sizeInputText = '';

        $this->orderInfo = session()->get('orderInfo', $this->orderInfo);
        $this->orderWsDetailSizes = session()->get('orderWsDetailSizes', $this->orderWsDetailSizes);
    }

    public function updateOutput()
    {
        $this->output = collect(DB::select("select output_defects.*, so_det.size, COUNT(output_defects.id) output from `output_defects` left join `so_det` on `so_det`.`id` = `output_defects`.`so_det_id` where `master_plan_id` = '".$this->orderInfo->id."' and `defect_status` = 'defect' group by so_det.id"));
    }

    public function updatedproductTypeImageAdd()
    {
        $this->validate([
            'productTypeImageAdd' => 'image',
        ]);
    }

    public function submitProductType()
    {
        if ($this->productTypeAdd && $this->productTypeImageAdd) {

            $productTypeImageAddName = md5($this->productTypeImageAdd . microtime()).'.'.$this->productTypeImageAdd->extension();
            $this->productTypeImageAdd->storeAs('public/images', $productTypeImageAddName);

            $createProductType = ProductType::create([
                'product_type' => $this->productTypeAdd,
                'image' => $productTypeImageAddName,
            ]);

            if ($createProductType) {
                $this->emit('alert', 'success', 'Product Time : '.$this->productTypeAdd.' berhasil ditambahkan.');

                $this->productTypeAdd = null;
                $this->productTypeImageAdd = null;
            } else {
                $this->emit('alert', 'error', 'Terjadi kesalahan.');
            }
        } else {
            $this->emit('alert', 'error', 'Harap tentukan nama tipe produk beserta gambarnya');
        }
    }

    public function submitDefectType()
    {
        if ($this->defectTypeAdd) {
            $createDefectType = DefectType::create([
                'defect_type' => $this->defectTypeAdd
            ]);

            if ($createDefectType) {
                $this->emit('alert', 'success', 'Defect type : '.$this->defectTypeAdd.' berhasil ditambahkan.');

                $this->defectTypeAdd = '';
            } else {
                $this->emit('alert', 'error', 'Terjadi kesalahan.');
            }
        } else {
            $this->emit('alert', 'error', 'Harap tentukan nama defect type');
        }
    }

    public function submitDefectArea()
    {
        if ($this->defectAreaAdd) {

            $createDefectArea = DefectArea::create([
                'defect_area' => $this->defectAreaAdd,
            ]);

            if ($createDefectArea) {
                $this->emit('alert', 'success', 'Defect area : '.$this->defectAreaAdd.' berhasil ditambahkan.');

                $this->defectAreaAdd = null;
            } else {
                $this->emit('alert', 'error', 'Terjadi kesalahan.');
            }
        } else {
            $this->emit('alert', 'error', 'Harap tentukan nama defect area');
        }
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

    public function selectDefectAreaPosition()
    {
        $masterPlan = MasterPlan::select('gambar')->find($this->orderInfo->id);

        if ($masterPlan) {
            $this->emit('showSelectDefectArea', $masterPlan->gambar);
        } else {
            $this->emit('alert', 'error', 'Harap pilih tipe produk terlebih dahulu');
        }
    }

    public function setDefectAreaPosition($x, $y)
    {
        $this->defectAreaPositionX = $x;
        $this->defectAreaPositionY = $y;
    }

    public function preSubmitInput()
    {
        $this->emit('clearSelectDefectAreaPoint');

        $this->defectType = null;
        $this->defectArea = null;
        $this->productType = null;
        $this->defectAreaPositionX = null;
        $this->defectAreaPositionY = null;

        $this->validateOnly('outputInput');
        $this->validateOnly('sizeInput');

        $this->emit('showModal', 'defect');
    }

    public function submitInput(SessionManager $session)
    {
        $validatedData = $this->validate();

        if ($this->orderInfo->tgl_plan == Carbon::now()->format('Y-m-d')) {
            $insertData = [];
            for ($i = 0; $i < $this->outputInput; $i++)
            {
                array_push($insertData, [
                    'master_plan_id' => $this->orderInfo->id,
                    'so_det_id' => $this->sizeInput,
                    // 'product_type_id' => $this->productType,
                    'defect_type_id' => $this->defectType,
                    'defect_area_id' => $this->defectArea,
                    'defect_area_x' => $this->defectAreaPositionX,
                    'defect_area_y' => $this->defectAreaPositionY,
                    'status' => 'NORMAL',
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            $insertDefect = DefectModel::insert($insertData);

            if ($insertDefect) {
                $type = DefectType::select('defect_type')->find($this->defectType);
                $area = DefectArea::select('defect_area')->find($this->defectArea);
                $getSize = DB::table('so_det')
                    ->select('id', 'size')
                    ->where('id', $this->sizeInput)
                    ->first();

                $this->emit('alert', 'success', $this->outputInput." output DEFECT berukuran ".$getSize->size." dengan jenis defect : ".$type->defect_type." dan area defect : ".$area->defect_area." berhasil terekam.");
                $this->emit('hideModal', 'defect');
                $this->emit('triggerDashboard', Auth::user()->line->username, Carbon::now()->format('Y-m-d'));

                $this->outputInput = 1;
                $this->sizeInput = '';
            } else {
                $this->emit('alert', 'error', "Terjadi kesalahan. Output tidak berhasil direkam.");
            }
        } else {
            $this->emit('alert', 'error', "Tidak dapat input backdate.");
        }
    }

    public function render(SessionManager $session)
    {
        $this->orderInfo = $session->get('orderInfo', $this->orderInfo);
        $this->orderWsDetailSizes = $session->get('orderWsDetailSizes', $this->orderWsDetailSizes);

        // Get total output
        $this->output = collect(DB::select("select output_defects.*, so_det.size, COUNT(output_defects.id) output from `output_defects` left join `so_det` on `so_det`.`id` = `output_defects`.`so_det_id` where `master_plan_id` = '".$this->orderInfo->id."' and `defect_status` = 'defect' group by so_det.id"));

        // Product types
        $this->productTypes = ProductType::orderBy('product_type')->get();

        // Defect types
        $this->defectTypes = DefectType::leftJoin(DB::raw("(select defect_type_id, count(id) total_defect from output_defects where updated_at between '".date("Y-m-d", strtotime(date("Y-m-d").' -10 days'))." 00:00:00' and '".date("Y-m-d")." 23:59:59' group by defect_type_id) as defects"), "defects.defect_type_id", "=", "output_defect_types.id")->whereRaw("(hidden IS NULL OR hidden != 'Y')")->orderBy('total_defect', 'desc')->get();

        // Defect areas
        $this->defectAreas = DefectArea::leftJoin(DB::raw("(select defect_area_id, count(id) total_defect from output_defects where updated_at between '".date("Y-m-d", strtotime(date("Y-m-d").' -10 days'))." 00:00:00' and '".date("Y-m-d")." 23:59:59' group by defect_area_id) as defects"), "defects.defect_area_id", "=", "output_defect_areas.id")->whereRaw("(hidden IS NULL OR hidden != 'Y')")->orderBy('total_defect', 'desc')->get();

        return view('livewire.defect');
    }
}
