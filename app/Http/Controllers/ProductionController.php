<?php

namespace App\Http\Controllers;

use App\Models\SignalBit\MasterPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $orderInfo = $orderSql->where('master_plan.id', $id)->first();
        $orderWsDetails = $orderSql->where('master_plan.sewing_line', Auth::user()->username)->where('act_costing.kpno', $orderInfo->ws_number)->get();

        return view('production-panel', ['orderInfo' => $orderInfo, 'orderWsDetails' => $orderWsDetails]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LineProductions  $lineProductions
     * @return \Illuminate\Http\Response
     */
    public function show(LineProductions $lineProductions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LineProductions  $lineProductions
     * @return \Illuminate\Http\Response
     */
    public function edit(LineProductions $lineProductions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LineProductions  $lineProductions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LineProductions $lineProductions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LineProductions  $lineProductions
     * @return \Illuminate\Http\Response
     */
    public function destroy(LineProductions $lineProductions)
    {
        //
    }
}
