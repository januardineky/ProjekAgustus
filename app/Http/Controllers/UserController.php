<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function auth(Request $request)
    {
        $validate = $request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($validate)) {
            return redirect('/index');
        }
        return redirect()->back();
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
