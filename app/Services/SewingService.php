<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\SignalBit\RftPacking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class SewingService
{
    public static function insertRftPacking($masterPlanId, $soDetId, $totalInput)
    {
        ini_set('max_execution_time', 360000);

        // Insert RFT for Finishing
        if (Auth::user()->is_sample) {
            $insertData = [];

            for ($i = 0; $i < $totalInput; $i++)
            {
                array_push($insertData, [
                    'master_plan_id' => $masterPlanId,
                    'so_det_id' => $soDetId,
                    'status' => 'NORMAL',
                    'created_by' => Auth::user() && Auth::user()->line ? Auth::user()->line->username : '',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            $insertRftPacking = RftPacking::insert($insertData);

            return $insertRftPacking;
        }

        return "Not Sample";
    }

    public static function insertRftPackingArr(array $rftArray)
    {
        ini_set('max_execution_time', 360000);

        // Insert RFT for Finishing
        if (Auth::user()->is_sample) {
            $username = Auth::user() && Auth::user()->line ? Auth::user()->line->username : '';

            foreach ($rftArray as &$item) {
                $item['created_by'] = $username;
            }

            unset($item); // recommended

            $insertRftPacking = RftPacking::insert($rftArray);

            return $insertRftPacking;
        }

        return "Not Sample";
    }
}
