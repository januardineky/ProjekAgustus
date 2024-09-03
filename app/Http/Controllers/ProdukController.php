<?php

namespace App\Http\Controllers;

use App\Models\keranjang;
use App\Models\Produk;
use App\Models\User;
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
        // $user = Auth()->user();

        // keranjang::create([
        //     'id_produk' => $request->id_produk,
        //     'id_user' => $user->id,
        //     'jumlah' => '1'
        // ]);
        // return redirect('/home');

        $user = Auth::user();

    // Ambil jumlah dari request, default ke 1 jika tidak ada
    $jumlah = $request->input('jumlah', 1);

    // Cek apakah produk sudah ada di keranjang
    $existingItem = Keranjang::where('id_produk', $request->id_produk)
        ->where('id_user', $user->id)
        ->first();

    if ($existingItem) {
        // Jika produk sudah ada, tambahkan jumlahnya
        $existingItem->jumlah += $jumlah;
        $existingItem->total = $existingItem->jumlah * $existingItem->item->harga; // Update total
        $existingItem->save();
    } else {
        // Jika produk belum ada, tambahkan ke keranjang
        $produk = Produk::find($request->id_produk);
        Keranjang::create([
            'id_produk' => $request->id_produk,
            'id_user' => $user->id,
            'jumlah' => $jumlah,
            'total' => $jumlah * $produk->harga
        ]);
    }

    return redirect('/home');
    }

    public function home()
    {
        $data['produk'] = Produk::all();
        $data['keranjang'] = keranjang::where('id_user',Auth()->user()->id)->first();
        return view('home', $data);
    }

    public function cart($keranjang)
    {
        // $data['user'] = Keranjang::where('id_user',$keranjang)->with('user')->first();
        // $data['produk'] = Keranjang::with(['item', 'user'])
        // ->where('id_user', $keranjang)
        // ->get();
        // return view('cart', $data);

        // dd($data['produk']);

        $data['user'] = User::find($keranjang);
        $data['produk'] = Keranjang::with('item')
        ->where('id_user', $keranjang)
        ->get();

    return view('cart', $data);
    }

    public function editjumlah($keranjang)
    {

        $data['user'] = User::find($keranjang);
        $produk = Keranjang::with('item')
        ->where('id_user', $keranjang)
        ->get();

        $totalHarga = $produk->sum(function ($item) {
            return $item->jumlah * $item->item->harga;
        });

        return view('cart', compact('produk', 'totalHarga'),$data);
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
