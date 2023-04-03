<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\SignalBit\UserPassword;

class LoginController extends Controller
{
    public function index() {
        return view("auth.login");
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->validated();

        $user = UserPassword::where('username', $credentials['username'])->where('Password', $credentials['password'])->first();

        if ($user) {
            Auth::login($user);

            $request->session()->regenerate();

            session(['user_id' => Auth::user()->id, 'user_name' => Auth::user()->username]);

            return array(
                'status' => '200',
                'message' => 'Authenticate Success',
                'redirect' => '/',
                'additional' => [],
            );
        }

        return array(
            'status' => '400',
            'message' => 'Username or Password is false',
            'redirect' => '',
            'additional' => ['username', 'password']
        );
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function unauthenticate(Request $request)
    {
        if ($request->confirmed) {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return array(
                "status" => 200,
                "message" => "Unauthenticate Success",
                "redirect" => "/login"
            );
        }
    }
}
