<?php

namespace App\Models\SignalBit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reject extends Model
{
    use HasFactory;

    protected $table = 'reject_output';

    protected $fillable = [
        'nama_area_defect',
        'jenis_defect_id',
        'created_at',
        'updated_at',
    ];

    public function defectType()
    {
        return $this->belongsTo(DefectType::class, 'jenis_defect_id', 'id');
    }
}
