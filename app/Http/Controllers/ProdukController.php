<?php

namespace App\Http\Controllers;

use App\Models\keranjang;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public function tambah($id)
    {
        $itemHarga = Produk::where('id', $id)->value('harga');

        $jumlah = keranjang::where('id_user', auth()->user()->id)
            ->where('id_produk', $id)
            ->value('jumlah');

        $subtotal = ($jumlah ?: 0) + 1;
        $subtotalValue = $itemHarga * $subtotal;

        keranjang::with('item')->updateOrInsert([
        'id_user' => auth()->user()->id,
        'id_produk' => $id,
        ],[
        'jumlah' => $subtotal,
        'subtotal' => $subtotalValue,
        'status' => 'Belum Dipesan'
        ]);

        return redirect('/home');
    }

    public function home()
    {
        $data['produk'] = Produk::all();
        $data['keranjang'] = keranjang::where('id_user',Auth()->user()->id)->first();
        return view('home', $data);
    }

    public function cart()
    {
        $data['produk'] = keranjang::with('item')->get();
        $data['jumlah'] = $data['produk']->count();
        $total = 0;
        foreach ($data['produk'] as $keranjang) {
            $total += $keranjang->subtotal;
        }
        $data['total'] = $total;
        return view('cart', $data);
    }

    public function editjumlah($id, Request $request)
    {
    $keranjang = keranjang::with('item')->where('id',$id)->first();

    $keranjang->update([
        'jumlah' => $request->jumlah,
        'subtotal' => $keranjang->item->harga * $request->jumlah
    ]);

    return redirect('/home/cart');
    }

    public function hapusproduk($keranjang)
    {
        $item = Keranjang::find($keranjang);

        if ($item) {
            $item->delete();
        }
        return redirect()->back();
    }
}
