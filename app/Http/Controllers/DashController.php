<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class DashController extends Controller
{
    public function index()
    {
        $buku = Buku::join('kategori', 'buku.idkategori', '=', 'kategori.idkategori')
        ->select('buku.*', 'kategori.nama AS nama_kategori')
        ->get();

        return response()->view("dashboard", ["buku" => $buku]);
    }
}
