<?php

namespace App\Http\Controllers;

use App\Models\keranjang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function pelanggan()
    {
        $data['pelanggan'] = User::where('level','=','pelanggan')->get();
        return view('pelanggan',$data);
    }

    public function caripelanggan(Request $request)
    {
        $data['pelanggan'] = User::where('level','=','pelanggan')->where('name','LIKE','%'.$request->cari.'%')->get();
        return view('pelanggan',$data);
    }

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
            'detail' => $request->detail,
        ]);
        // $keranjang = new keranjang();
        // $keranjang->id_user = $user->id;
        // $keranjang->save();
        return redirect('/');
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
                // $id_user = auth()->user()->id;
                return redirect('/home');
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
