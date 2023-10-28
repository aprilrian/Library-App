<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';
    protected $fillable = [
        'idtransaksi',
        'idbuku',
        'tgl_kembali',
        'denda',
        'idpetugas',
    ];

    public $timestamps = false;


    public function buku()
    {
        return $this->belongsTo(Buku::class, 'idbuku');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'idtransaksi');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'idpetugas');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'idanggota');
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'idpeminjaman');
    }
}

