<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $fillable = [
        'noktp', 'tgl_pinjam', 'idpetugas', 'idbuku'
    ];

    public $primaryKey = "idtransaksi";

    public $timestamps = false;

public function detailTransaksi()
{
    return $this->hasMany(DetailTransaksi::class, 'idtransaksi', 'idtransaksi');
}


}
