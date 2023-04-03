<?php

namespace App\Models\SignalBit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\UserPassword as Authenticatable;

class UserPassword extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'username';

    protected $connection = 'mysql_sb';

    protected $table = 'userpassword';

    protected $fillable = [
        'username',
        'FullName',
        'Password',
        'Locked'
    ];

    public function getAuthPassword() {
        return $this->Password;
    }

    public function masterPlans()
    {
        return $this->hasMany(MasterPlan::class, 'sewing_line', 'username');
    }
}
