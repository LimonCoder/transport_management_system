<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{

    // impersonate
    public function impersonate($id)
    {
        $user = User::find($id);
        $auth_id = Auth::user()->id;

        if ($user) {
            Auth::login($user);

            session([
                "auth_user_id" => $auth_id,
            ]);
            return redirect()->intended('home');
        } else {
            return redirect()->back();
        }

    }

    // impersonate leave
    public function impersonateleave()
    {

        $user_id = session('auth_user_id');
        $user = User::find($user_id);
        if ($user) {
            Auth::login($user);
            // unset session
            session()->forget('auth_user_id');
            return redirect()->intended('home');
        } else {
            return redirect()->route('logout');
        }


    }
}
