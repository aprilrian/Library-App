<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'detail_transaksi';
    protected $fillable = [
        'buku_id', 'peminjam_id', 'tanggal_peminjaman', 'tanggal_pengembalian', 'tanggal_pengembalian_sebenarnya', 'biaya_denda', 'status',
    ];

    public function buku()
    {
        return $this->belongsTo('App\Buku', 'buku_id');
    }

    public function peminjam()
    {
        return $this->belongsTo('App\Peminjam', 'peminjam_id');
    }
}
