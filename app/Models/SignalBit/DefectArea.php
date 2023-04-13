<?php

namespace App\Models\SignalBit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefectArea extends Model
{
    use HasFactory;

    protected $connection = 'mysql_sb';

    protected $table = 'output_defect_areas';

    protected $fillable = [
        'id',
        'defect_type_id',
        'defect_area',
        'created_at',
        'updated_at',
    ];

    public function defectType()
    {
        return $this->belongsTo(DefectType::class, 'defect_type_id', 'id');
    }

    public function defects()
    {
        return $this->hasMany(Defect::class, 'id', 'defect_area_id');
    }
}
