<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordPostRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function changePassword(ChangePasswordPostRequest $request)
    {
        $password = $request->get('password');
        $user = $request->user();
        $user->update(['password' => bcrypt($password)]);
        return redirect('/home');
    }

    public function change(Request $request)
    {
        $user = $request->user();
        return view('change', compact('user'));
    }
}
