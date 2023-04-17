<?php

namespace App\Models\SignalBit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Defect extends Model
{
    use HasFactory;

    protected $connection = 'mysql_sb';

    protected $table = 'output_defects';

    protected $fillable = [
        'id',
        'master_plan_id',
        'so_det_id',
        'area_defect_id',
        'defect_status',
        'status',
        'created_at',
        'updated_at',
    ];

    public function masterPlan()
    {
        return $this->belongsTo(MasterPlan::class, 'master_plan_id', 'id');
    }

    public function defectArea()
    {
        return $this->belongsTo(DefectArea::class, 'defect_area_id', 'id');
    }

    public function rework()
    {
        return $this->hasOne(Rework::class, 'id', 'defect_id');
    }
}
