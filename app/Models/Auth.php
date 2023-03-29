<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserCredential;

class Auth extends Model
{
    use HasFactory;

    public static function attempt($credentials) {
        $authenticate = UserCredential::where('username', $credentials->username)->where('Password', $credentials->password)->get();

        if ($authenticate) {
            return true;
        }

        return false;
    }
}
