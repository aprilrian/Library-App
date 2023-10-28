<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
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
        $kategori = Kategori::all();
        return view('buku.create', ['kategori'=>$kategori]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'isbn' => 'required|regex:/^\d{3}-\d{10}$/',
            'judul' => 'required|string|max:50',
            'pengarang' => 'required|string|max:50',
            'penerbit' => 'required|string|max:50',
            'kota_terbit' => 'required|string|max:50',
            'editor' => 'required|string|max:50',
            'stok' => 'required|numeric',
            'stok_tersedia' => 'required|numeric',
            'idkategori' => 'required',
        ], [
            'isbn.required' => 'Nomor ISBN wajib diisi.',
            'isbn.regex' => 'ISBN format salah. Contoh: 123-4567891',
            'judul.required' => 'Judul buku wajib diisi.',
            'judul.string' => 'Judul buku harus berupa teks.',
            'judul.max' => 'Judul buku tidak boleh melebihi 50 karakter.',
            'pengarang.required' => 'Nama pengarang wajib diisi.',
            'pengarang.string' => 'Nama pengarang harus berupa teks.',
            'pengarang.max' => 'Nama pengarang tidak boleh melebihi 50 karakter.',
            'penerbit.required' => 'Nama penerbit wajib diisi.',
            'penerbit.string' => 'Nama penerbit harus berupa teks.',
            'penerbit.max' => 'Nama penerbit tidak boleh melebihi 50 karakter.',
            'kota_terbit.required' => 'Kota terbit wajib diisi.',
            'kota_terbit.string' => 'Kota terbit harus berupa teks.',
            'kota_terbit.max' => 'Kota terbit tidak boleh melebihi 50 karakter.',
            'editor.required' => 'Nama editor wajib diisi.',
            'editor.string' => 'Nama editor harus berupa teks.',
            'editor.max' => 'Nama editor tidak boleh melebihi 50 karakter.',
            'stok.required' => 'Stok buku wajib diisi.',
            'stok.numeric' => 'Stok buku harus berupa angka.',
            'stok_tersedia.required' => 'Stok tersedia buku wajib diisi.',
            'stok_tersedia.numeric' => 'Stok tersedia buku harus berupa angka.',
            'idkategori.required' => 'Kategori wajib diisi.',
        ]);

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
            $request->file('file_gambar')->move('buku/', $request->file('file_gambar')->getClientOriginalName());
            $buku->file_gambar = $request->file('file_gambar')->getClientOriginalName();
        }

        $buku->save();

        return redirect()->route('buku.index')->with('success', 'Data Buku berhasil ditambahkan');
    }

    public function edit($isbn)
    {
        $kategori = Kategori::all();
        $buku = Buku::where('isbn', $isbn)->first();
        return view('buku.edit')->with(['buku' => $buku, 'kategori' => $kategori]);
    }

    public function update(Request $request, $isbn)
    {
        $request->validate([
            'isbn' => 'required|regex:/^\d{3}-\d{10}$/',
            'judul' => 'required|string|max:50',
            'pengarang' => 'required|string|max:50',
            'penerbit' => 'required|string|max:50',
            'kota_terbit' => 'required|string|max:50',
            'editor' => 'required|string|max:50',
            'stok' => 'required|numeric',
            'stok_tersedia' => 'required|numeric',
            'idkategori' => 'required',
            'file_gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
        ], [
            // Pesan kesalahan validasi
        ]);

        $buku = Buku::where('isbn', $isbn)->first();
        $kategori = Kategori::all();

        if (!$buku) {
            return redirect()->route('buku.index')->with([
                'error' => 'Buku tidak ditemukan.',
            ]);
        }

        $buku->isbn = $request->isbn;
        $buku->judul = $request->judul;
        $buku->pengarang = $request->pengarang;
        $buku->penerbit = $request->penerbit;
        $buku->kota_terbit = $request->kota_terbit;
        $buku->editor = $request->editor;
        $buku->stok = $request->stok;
        $buku->stok_tersedia = $request->stok_tersedia;
        $buku->idkategori = $request->idkategori;

        if ($request->hasFile('file_gambar')) {
            // Hapus gambar lama jika ada
            if ($buku->file_gambar) {
                $oldImagePath = public_path('buku/' . $buku->file_gambar);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Simpan gambar yang baru diunggah
            $file = $request->file('file_gambar');
            $fileName = $file->getClientOriginalName();
            $file->move('buku/', $fileName);
            $buku->file_gambar = $fileName;
        }

        $buku->save();

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
