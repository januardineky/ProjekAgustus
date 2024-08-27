<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function register()
    {
        return view('register');
    }

    public function createuser(Request $request)
    {
            User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no' => $request->no,
            'password' => bcrypt($request->password),
            'jalan' => $request->jalan,
            'kab' => $request->kab,
            'level' => 'pelanggan',
            'kec' => $request->kec,
            'pos' => $request->pos,
            'detail' => $request->detail
        ]);
        return redirect('/');


        // $user = new User();
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->no = $request->no;
        // $user->password = bcrypt($request->password);
        // $user->jalan = $request->jalan;
        // $user->kab = $request->kab;
        // $user->level = 'pelanggan';
        // $user->kec = $request->kec;
        // $user->pos = $request->pos;
        // $user->detail = $request->detail;
        // $user->save();
    }

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
                $id_user = auth()->user()->id;
                return redirect('/home')->with($id_user);
            }
        }
        return redirect()->back()->with('pesan', 'Login anda Gagal!');

    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
