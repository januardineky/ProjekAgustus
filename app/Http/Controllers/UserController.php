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

        if (auth()->attempt($validate)) {

            // buat ulang session login
            $request->session()->regenerate();

            if (auth()->user()->level === 'admin') {
                return redirect('/index');
            }
            else {
                return redirect('/home');
            }
        }
        return redirect()->back();

    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
