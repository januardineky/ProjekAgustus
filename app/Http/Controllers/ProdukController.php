<?php

namespace App\Http\Controllers;

use App\Models\keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $data['produk'] = Produk::all();
        $data['total_produk'] = $data['produk']->count();
        return view('index',$data);
    }

    public function home()
    {
        $data['produk'] = Produk::all();
        $data['id_user'] = Session::get("id");
        return view('home', $data);
    }

    public function search(Request $request)
    {
        $data['produk'] = Produk::where('name','LIKE','%'.$request->cari.'%')->orwhere('kategori','LIKE','%'.$request->cari.'%')->get();
        $data['total_produk'] = $data['produk']->count();
        return view('index',$data);
    }

    public function cari(Request $request)
    {
        $data['produk'] = Produk::where('name','LIKE','%'.$request->cari.'%')->orwhere('kategori','LIKE','%'.$request->cari.'%')->get();
        $data['total_produk'] = $data['produk']->count();
        return view('search',$data);
    }

    public function create()
    {
        return view('create');
    }

    public function input(Request $request)
    {
        $filename = '';
        if ($request->file('gambar')) {
            $extfile = $request->file('gambar')->getClientOriginalExtension();
            $filename = time().".".$extfile;
            $request -> file('gambar')->storeAs('gambar',$filename);
        }

        Produk::create([
            'name' => $request->name,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $filename
        ]);

        return redirect('index');
    }

    public function delete(Request $request)
    {
        Produk::where('id',$request->id)->delete();
        return redirect('/index');
    }

    public function edit(Request $request)
    {
        $data['produk'] = Produk::find($request->id);
        return view('edit',$data);
    }

    public function update(Request $request)
    {
        $produk = Produk::where('id',$request->id)->first();
        if ($produk->gambar) {
            Storage::delete('gambar/'.$produk->gambar);
        }

        $filename = '';
        if ($request->file('gambar')) {
            $extfile = $request->file('gambar')->getClientOriginalExtension();
            $filename = time().".".$extfile;
            $request -> file('gambar')->storeAs('gambar',$filename);
        }

        $produk->update([
            'name' => $request->name,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $filename
        ]);

        return redirect('/index');
    }

    public function tambah(Request $request)
    {
        keranjang::create([
            'id_produk' => $request->id_produk,
            'id_user' => $request->id_user,
        ]);
        return redirect('/home');
    }

    public function cart()
    {
        return view('cart');
    }
}
