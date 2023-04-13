<?php

namespace App\Models\SignalBit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\UserPassword as Authenticatable;

class UserPassword extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'id_line';

    protected $connection = 'mysql_sb';

    protected $table = 'userpassword';

    protected $fillable = [
        'username',
        'FullName',
        'Password',
        'password_encrypt'
    ];

    public function getAuthPassword() {
        return $this->password_encrypt;
    }

    public function masterPlans()
    {
        return $this->hasMany(MasterPlan::class, 'username', 'sewing_line');
    }
}
