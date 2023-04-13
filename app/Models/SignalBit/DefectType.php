<?php

namespace App\Models\SignalBit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefectType extends Model
{
    use HasFactory;

    protected $connection = 'mysql_sb';

    protected $table = 'jenis_defect_output';

    protected $fillable = [
        'nama_jenis_defect',
        'created_at',
        'updated_at',
    ];

    public function defectArea()
    {
        return $this->hasMany(DefectArea::class, 'id', 'jenis_defect_id');
    }
}
