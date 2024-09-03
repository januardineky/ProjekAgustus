<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjangs';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function item()
    {
        return $this->belongsTo(Produk::class, 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user','id');
    }
}
