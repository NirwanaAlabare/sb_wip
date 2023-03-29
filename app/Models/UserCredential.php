<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCredential extends Model
{
    use HasFactory;

    protected $table = 'userpassword';

    protected $fillable = [
        'username',
        'FullName',
        'Password',
    ]

    protected $hidden = [
        'Password',
        'remember_token',
    ];
}
