<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Session\SessionManager;
use App\Models\SignalBit\Defect;
use App\Models\SignalBit\Reject as RejectModel;
use App\Models\SignalBit\MasterPlan;
use Carbon\Carbon;
use DB;

class Reject extends Component
{
    public $orderInfo;
    public $orderWsDetailSizes;
    public $output;
    public $outputInput;
    public $sizeInput;
    public $sizeInputText;

    public $searchDefect;
    public $searchReject;
    public $defectImage;
    public $defectPositionX;
    public $defectPositionY;
    public $allDefectListFilter;
    public $allDefectImage;
    public $allDefectPosition;
    public $massQty;
    public $massSize;
    public $massDefectType;
    public $massDefectTypeName;
    public $massDefectArea;
    public $massDefectAreaName;
    public $massSelectedDefect;
    public $info;

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

    protected $listeners = [
        'updateWsDetailSizes' => 'updateWsDetailSizes',
        'updateOutputReject' => 'updateOutput',

        'submitReject' => 'submitReject',
        'submitAllReject' => 'submitAllReject',
        'cancelReject' => 'cancelReject',
        'hideDefectAreaImageClear' => 'hideDefectAreaImage',
        'updateWsDetailSizes' => 'updateWsDetailSizes'
    ];

    public function mount(SessionManager $session, $orderWsDetailSizes)
    {
        $this->orderWsDetailSizes = $orderWsDetailSizes;
        $session->put('orderWsDetailSizes', $orderWsDetailSizes);
        $this->outputInput = 1;
        $this->sizeInput = null;
        $this->sizeInputText = null;
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
        $this->output = RejectModel::
            leftJoin("so_det", "so_det.id", "=", "output_rejects.so_det_id")->
            where('master_plan_id', $this->orderInfo->id)->
            get();
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
                    'status' => 'NORMAL',
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            $insertReject = RejectModel::insert($insertData);

            if ($insertReject) {
                $getSize = DB::table('so_det')
                    ->select('id', 'size')
                    ->where('id', $this->sizeInput)
                    ->first();

                $this->emit('alert', 'success', $this->outputInput." REJECT output berukuran ".$getSize->size." berhasil terekam.");

                $this->outputInput = 1;
                $this->sizeInput = '';
            } else {
                $this->emit('alert', 'error', "Terjadi kesalahan. Output tidak berhasil direkam.");
            }
        } else {
            $this->emit('alert', 'error', "Tidak dapat input backdate.");
        }
    }

    public function closeInfo()
    {
        $this->info = false;
    }

    public function setDefectAreaPosition($x, $y)
    {
        $this->defectPositionX = $x;
        $this->defectPositionY = $y;
    }

    public function showDefectAreaImage($defectImage, $x, $y)
    {
        $this->defectImage = $defectImage;
        $this->defectPositionX = $x;
        $this->defectPositionY = $y;

        $this->emit('showDefectAreaImage', $this->defectImage, $this->defectPositionX, $this->defectPositionY);
    }

    public function hideDefectAreaImage()
    {
        $this->defectImage = null;
        $this->defectPositionX = null;
        $this->defectPositionY = null;
    }

    public function updatingSearchDefect()
    {
        $this->resetPage('defectsPage');
    }

    public function updatingSearchReject()
    {
        $this->resetPage('rejectsPage');
    }

    public function submitAllReject() {
        $availableReject = 0;
        $externalReject = 0;

        $allDefect = Defect::selectRaw('output_defects.id id, output_defects.master_plan_id master_plan_id, output_defects.so_det_id so_det_id, output_defects.kode_numbering, output_defects.no_cut_size, output_defect_types.allocation, output_defect_in_out.status in_out_status')->
            leftJoin('so_det', 'so_det.id', '=', 'output_defects.so_det_id')->
            leftJoin('output_defect_in_out', 'output_defect_in_out.defect_id', '=', 'output_defects.id')->
            leftJoin('output_defect_types', 'output_defect_types.id', '=', 'output_defects.defect_type_id')->
            where('output_defects.defect_status', 'defect')->
            where('output_defects.master_plan_id', $this->orderInfo->id)->
            whereNull('output_defects.kode_numbering')->
            get();

        if ($allDefect->count() > 0) {
            $defectIds = [];
            foreach ($allDefect as $defect) {
                if ($defect->in_out_status != "defect") {
                    // create reject
                    $createReject = RejectModel::create([
                        "master_plan_id" => $defect->master_plan_id,
                        "so_det_id" => $defect->so_det_id,
                        "defect_id" => $defect->id,
                        "status" => "NORMAL",
                        "kode_numbering" => $defect->kode_numbering,
                        "no_cut_size" => $defect->no_cut_size,
                        'created_by' => Auth::user()->id
                    ]);

                    // add defect ids
                    array_push($defectIds, $defect->id);

                    $availableReject += 1;
                } else {
                    $externalReject += 1;
                }
            }
            // update defect
            $defectSql = Defect::whereIn('id', $defectIds)->update([
                "defect_status" => "rejected"
            ]);

            if ($availableReject > 0) {
                $this->emit('alert', 'success', $availableReject." DEFECT berhasil di REJECT");
            } else {
                $this->emit('alert', 'error', "Terjadi kesalahan. DEFECT tidak berhasil di REJECT.");
            }

            if ($externalReject > 0) {
                $this->emit('alert', 'warning', $externalReject." DEFECT masih di proses MANDING/SPOTCLEANING.");
            }

        } else {
            $this->emit('alert', 'warning', "Data tidak ditemukan.");
        }
    }

    public function preSubmitMassReject($defectType, $defectArea, $defectTypeName, $defectAreaName) {
        $this->massQty = 1;
        $this->massSize = '';
        $this->massDefectType = $defectType;
        $this->massDefectTypeName = $defectTypeName;
        $this->massDefectArea = $defectArea;
        $this->massDefectAreaName = $defectAreaName;

        $this->emit('showModal', 'massReject');
    }

    public function submitMassReject() {
        $availableReject = 0;
        $externalReject = 0;

        $selectedDefect = Defect::selectRaw('output_defects.id id, output_defects.master_plan_id master_plan_id, output_defects.so_det_id so_det_id, output_defects.kode_numbering, output_defects.no_cut_size, output_defect_types.allocation, so_det.size, output_defect_in_out.status in_out_status')->
            leftJoin('so_det', 'so_det.id', '=', 'output_defects.so_det_id')->
            leftJoin('output_defect_in_out', 'output_defect_in_out.defect_id', '=', 'output_defects.id')->
            leftJoin('output_defect_types', 'output_defect_types.id', '=', 'output_defects.defect_type_id')->
            where('output_defects.defect_status', 'defect')->
            where('output_defects.master_plan_id', $this->orderInfo->id)->
            where('output_defects.defect_type_id', $this->massDefectType)->
            where('output_defects.defect_area_id', $this->massDefectArea)->
            where('output_defects.so_det_id', $this->massSize)->
            whereNull('output_defects.kode_numbering')->
            take($this->massQty)->get();

        if ($selectedDefect->count() > 0) {
            $defectIds = [];
            foreach ($selectedDefect as $defect) {
                if ($defect->in_out_status != "defect") {
                    // create reject
                    $createReject = RejectModel::create([
                        "master_plan_id" => $defect->master_plan_id,
                        "so_det_id" => $defect->so_det_id,
                        "defect_id" => $defect->id,
                        "status" => "NORMAL",
                        "kode_numbering" => $defect->kode_numbering,
                        "no_cut_size" => $defect->no_cut_size,
                        'created_by' => Auth::user()->id
                    ]);

                    // add defect id array
                    array_push($defectIds, $defect->id);

                    $availableReject += 1;
                } else {
                    $externalRework += 1;
                }
            }
            // update defect
            $defectSql = Defect::whereIn('id', $defectIds)->update([
                "defect_status" => "rejected"
            ]);

            if ($availableReject > 0) {
                $this->emit('alert', 'success', "DEFECT dengan Ukuran : ".$selectedDefect[0]->size.", Tipe : ".$this->massDefectTypeName." dan Area : ".$this->massDefectAreaName." berhasil di REJECT sebanyak ".$selectedDefect->count()." kali.");

                $this->emit('hideModal', 'massRework');
            } else {
                $this->emit('alert', 'error', "Terjadi kesalahan. DEFECT dengan Ukuran : ".$selectedDefect[0]->size.", Tipe : ".$this->massDefectTypeName." dan Area : ".$this->massDefectAreaName." tidak berhasil di REJECT.");
            }

            if ($externalReject > 0) {
                $this->emit('alert', 'warning', $externalReject." DEFECT masih ada yang di proses MENDING/SPOTCLEANING.");
            }
        } else {
            $this->emit('alert', 'warning', "Data tidak ditemukan.");
        }
    }

    public function submitReject($defectId) {
        $externalReject = 0;

        $thisDefectReject = RejectModel::where('defect_id', $defectId)->count();

        if ($thisDefectReject < 1) {
            // remove from defect
            $defect = Defect::where('id', $defectId);
            $getDefect = Defect::selectRaw('output_defects.*, output_defect_in_out.status')->leftJoin('output_defect_in_out', 'output_defect_in_out.defect_id', '=', 'output_defects.id')->where('output_defects.id', $defectId)->first();

            if ($getDefect->status != 'defect') {
                $updateDefect = $defect->update([
                    "defect_status" => "rejected"
                ]);

                // add to rework
                $createReject = RejectModel::create([
                    "master_plan_id" => $getDefect->master_plan_id,
                    "so_det_id" => $getDefect->so_det_id,
                    "defect_id" => $defectId,
                    "kode_numbering" => $getDefect->kode_numbering,
                    "no_cut_size" => $getDefect->no_cut_size,
                    'created_by' => Auth::user()->id,
                    "status" => "NORMAL"
                ]);

                if ($createReject && $updateDefect) {
                    $this->emit('alert', 'success', "DEFECT dengan ID : ".$defectId." berhasil di REJECT.");
                } else {
                    $this->emit('alert', 'error', "Terjadi kesalahan. DEFECT dengan ID : ".$defectId." tidak berhasil di REJECT.");
                }
            } else {
                $this->emit('alert', 'error', "DEFECT ini masih di proses MENDING/SPOTCLEANING. DEFECT dengan ID : ".$defectId." tidak berhasil di REJECT.");
            }
        } else {
            $this->emit('alert', 'warning', "Pencegahan data redundant. DEFECT dengan ID : ".$defectId." sudah ada di REJECT.");
        }
    }

    public function cancelReject($rejectId, $defectId) {
        // delete from rework
        $deleteReject = RejectModel::where('id', $rejectId)->delete();

        // add to defect
        $defect = Defect::where('id', $defectId);
        $getDefect = $defect->first();
        $updateDefect = $defect->update([
            "defect_status" => "defect"
        ]);

        if ($deleteReject && $updateDefect) {
            $this->emit('alert', 'success', "REJECT dengan REJECT ID : ".$rejectId." dan DEFECT ID : ".$defectId." berhasil di kembalikan ke DEFECT.");
        } else {
            $this->emit('alert', 'error', "Terjadi kesalahan. REJECT dengan REJECT ID : ".$rejectId." dan DEFECT ID : ".$defectId." tidak berhasil dikembalikan ke DEFECT.");
        }
    }

    public function render(SessionManager $session)
    {
        $this->orderInfo = $session->get('orderInfo', $this->orderInfo);
        $this->orderWsDetailSizes = $session->get('orderWsDetailSizes', $this->orderWsDetailSizes);

        // Get total output
        $this->output = RejectModel::
            leftJoin("so_det", "so_det.id", "=", "output_rejects.so_det_id")->
            where('master_plan_id', $this->orderInfo->id)->
            get();

        $this->allDefectImage = MasterPlan::select('gambar')->find($this->orderInfo->id);

        $this->allDefectPosition = Defect::where('output_defects.defect_status', 'defect')->
            where('output_defects.master_plan_id', $this->orderInfo->id)->
            get();

        $allDefectList = Defect::selectRaw('output_defects.defect_type_id, output_defects.defect_area_id, output_defect_types.defect_type, output_defect_areas.defect_area, count(*) as total')->
            leftJoin('output_defect_areas', 'output_defect_areas.id', '=', 'output_defects.defect_area_id')->
            leftJoin('output_defect_types', 'output_defect_types.id', '=', 'output_defects.defect_type_id')->
            where('output_defects.defect_status', 'defect')->
            where('output_defects.master_plan_id', $this->orderInfo->id)->
            whereNull('output_defects.kode_numbering')->
            whereRaw("
                (
                    output_defect_types.defect_type LIKE '%".$this->allDefectListFilter."%' OR
                    output_defect_areas.defect_area LIKE '%".$this->allDefectListFilter."%'
                )
            ")->
            groupBy('output_defects.defect_type_id', 'output_defects.defect_area_id', 'output_defect_types.defect_type', 'output_defect_areas.defect_area')->
            orderBy('output_defects.updated_at', 'desc')->
            paginate(5, ['*'], 'allDefectListPage');

        $defects = Defect::selectRaw('output_defects.*, so_det.size as so_det_size')->
            leftJoin('so_det', 'so_det.id', '=', 'output_defects.so_det_id')->
            leftJoin('output_defect_areas', 'output_defect_areas.id', '=', 'output_defects.defect_area_id')->
            leftJoin('output_defect_types', 'output_defect_types.id', '=', 'output_defects.defect_type_id')->
            where('output_defects.defect_status', 'defect')->
            where('output_defects.master_plan_id', $this->orderInfo->id)->
            whereNull('output_defects.kode_numbering')->
            whereRaw("(
                output_defects.id LIKE '%".$this->searchDefect."%' OR
                so_det.size LIKE '%".$this->searchDefect."%' OR
                output_defect_areas.defect_area LIKE '%".$this->searchDefect."%' OR
                output_defect_types.defect_type LIKE '%".$this->searchDefect."%' OR
                output_defects.defect_status LIKE '%".$this->searchDefect."%'
            )")->
            orderBy('output_defects.updated_at', 'desc')->paginate(10, ['*'], 'defectsPage');

        $rejects = RejectModel::selectRaw('output_rejects.*, so_det.size as so_det_size')->
            leftJoin('output_defects', 'output_defects.id', '=', 'output_rejects.defect_id')->
            leftJoin('output_defect_areas', 'output_defect_areas.id', '=', 'output_defects.defect_area_id')->
            leftJoin('output_defect_types', 'output_defect_types.id', '=', 'output_defects.defect_type_id')->
            leftJoin('so_det', 'so_det.id', '=', 'output_defects.so_det_id')->
            where('output_defects.defect_status', 'rejected')->
            where('output_defects.master_plan_id', $this->orderInfo->id)->
            whereNull('output_defects.kode_numbering')->
            whereRaw("(
                output_rejects.id LIKE '%".$this->searchReject."%' OR
                output_defects.id LIKE '%".$this->searchReject."%' OR
                so_det.size LIKE '%".$this->searchReject."%' OR
                output_defect_areas.defect_area LIKE '%".$this->searchReject."%' OR
                output_defect_types.defect_type LIKE '%".$this->searchReject."%' OR
                output_defects.defect_status LIKE '%".$this->searchReject."%'
            )")->
            orderBy('output_rejects.updated_at', 'desc')->paginate(10, ['*'], 'rejectsPage');

        $this->massSelectedDefect = Defect::selectRaw('output_defects.so_det_id, so_det.size as size, count(*) as total')->
            leftJoin('so_det', 'so_det.id', '=', 'output_defects.so_det_id')->
            where('output_defects.defect_status', 'defect')->
            where('output_defects.master_plan_id', $this->orderInfo->id)->
            where('output_defects.defect_type_id', $this->massDefectType)->
            where('output_defects.defect_area_id', $this->massDefectArea)->
            groupBy('output_defects.so_det_id', 'so_det.size')->get();

        return view('livewire.reject', ['defects' => $defects, 'rejects' => $rejects, 'allDefectList' => $allDefectList]);
    }

    public function dehydrate()
    {
        $this->resetValidation();
        $this->resetErrorBag();
    }
}
