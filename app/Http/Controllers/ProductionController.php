<?php

namespace App\Http\Controllers;

use App\Models\SignalBit\MasterPlan;
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
        $orderSql = MasterPlan::selectRaw("
                DISTINCT act_costing.kpno, master_plan.tgl_plan, mastersupplier.supplier, act_costing.styleno, so.qty,
                master_plan.id as id,
                master_plan.tgl_plan as plan_date,
                mastersupplier.supplier as buyer_name,
                act_costing.kpno as ws_number,
                act_costing.styleno as style_name,
                so.id as id,
                so.qty as qty_order,
                so_det.color as color,
                so_det.size as size
            ")
            ->leftJoin('so_det', 'so_det.id', '=', 'master_plan.id_so_det')
            ->leftJoin('so', 'so.id', '=', 'so_det.id_so')
            ->leftJoin('act_costing', 'act_costing.id', '=', 'so.id_cost')
            ->leftJoin('mastersupplier', 'mastersupplier.id_supplier', '=', 'act_costing.id_buyer');

        return view('production-panel', ['orderSql' => $orderSql, 'plan_id' => $id]);
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
