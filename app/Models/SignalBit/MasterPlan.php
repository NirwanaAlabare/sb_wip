<?php

namespace App\Models\SignalBit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPlan extends Model
{
    use HasFactory;

    protected $connection = 'mysql_sb';

    protected $table = 'master_plan';

    protected $fillable = [];

    public function userPassword()
    {
        return $this->hasMany(UserPassword::class, 'sewing_line', 'username');
    }

    public function rfts()
    {
        return $this->hasMany(Rft::class, 'id', 'master_plan_id');
    }

    public function defects()
    {
        return $this->hasMany(Defect::class, 'id', 'master_plan_id');
    }

    public function rejects()
    {
        return $this->hasMany(Reject::class, 'id', 'master_plan_id');
    }

    public function reworks()
    {
        return $this->hasMany(Rework::class, 'id', 'master_plan_id');
    }
}
