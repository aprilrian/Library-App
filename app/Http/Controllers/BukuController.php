<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::join('kategori', 'buku.idkategori', '=', 'kategori.idkategori')
        ->select('buku.*', 'kategori.nama AS nama_kategori')
        ->get();

        return response()->view("buku.index", ["buku" => $buku]);
    }

    public function create()
    {
        return view('buku.create')->with([]);
    }

    public function store(Request $request)
    {
        $buku = new Buku();

        $buku->isbn = $request->input('isbn');
        $buku->judul = $request->input('judul');
        $buku->pengarang = $request->input('pengarang');
        $buku->penerbit = $request->input('penerbit');
        $buku->kota_terbit = $request->input('kota_terbit');
        $buku->editor = $request->input('editor');
        $buku->stok = $request->input('stok');
        $buku->stok_tersedia = $request->input('stok_tersedia');
        $buku->idkategori = $request->input('idkategori');

        if ($request->hasFile('file_gambar')) {
            $request->file('file_gambar')->move('coverbuku/', $request->file('file_gambar')->getClientOriginalName());
            $buku->file_gambar = $request->file('file_gambar')->getClientOriginalName();
            $buku->save();
        }

        $buku->save();

        return redirect()->route('buku.index')->with('success', 'Data Buku berhasil ditambahkan');
    }

    public function edit($isbn)
    {
        $buku = Buku::where('isbn', $isbn)->first();
        return view('buku.edit')->with(['buku' => $buku]);
    }

    public function update(Request $request, $isbn)
    {
        $buku = Buku::where('isbn', $isbn)->first();

        if (!$buku) {
            return redirect()->route('buku.index')->with([
                'error' => 'Buku tidak ditemukan.',
            ]);
        }

        $buku->update([
            'isbn' => $request->isbn,
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'kota_terbit' => $request->kota_terbit,
            'editor' => $request->editor,
            'stok' => $request->stok,
            'stok_tersedia' => $request->stok_tersedia,
            'idkategori' => $request->idkategori,
            'file_gambar' => $request->file_gambar,
        ]);

        return redirect()->route('buku.index')->with([
            'success' => 'Data Buku berhasil diperbarui',
        ]);
    }


    public function destroy($isbn)
    {
        $buku = Buku::where('isbn',$isbn)->first();
        if(!$buku) {
            return redirect()->route('buku.index')->with([
                'error' => 'Data Buku tidak ditemukan'
            ]);
        }

        $buku->delete();

        return redirect()->route('buku.index')->with([
            'success' => 'Data Buku berhasil dihapus',
        ]);
    }

}
