<?php

namespace App\Models\SignalBit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPlan extends Model
{
    use HasFactory;

    protected $connection = 'mysql_sb';

    protected $table = 'master_plan';

    protected $fillable = [
        'tgl_plan',
        'id_so_det',
        'smv',
        'jam_kerja',
        'man_power',
        'tgl_input',
        'cancel'
    ];

    public function userPassword()
    {
        return $this->hasMany(UserPassword::class, 'sewing_line', 'username');
    }

    public function Rfts()
    {
        return $this->hasMany(Rft::class, 'id', 'master_plan_id');
    }
}
