<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 


class TransaksiController extends Controller
{
    public function index()
    {
        $transaksiBerlangsung = [];

        $transaksi = DetailTransaksi::join('buku', 'buku.id', '=', 'detail_transaksi.idbuku')
        ->leftJoin('peminjaman', 'peminjaman.idtransaksi', '=', 'detail_transaksi.idtransaksi')
        ->leftJoin('anggota', 'anggota.noktp', '=', 'peminjaman.noktp')
        ->leftJoin('petugas', 'petugas.idpetugas', '=', 'detail_transaksi.idpetugas')
        ->select('detail_transaksi.*', 'buku.judul AS judul_buku', 'peminjaman.tgl_pinjam AS tanggal_peminjaman', 'anggota.nama AS nama', 'petugas.nama AS namapetugas', 'buku.isbn AS isbn')
        ->orderBy('detail_transaksi.idtransaksi', 'asc')
        ->get();

        // Hitung denda dan pisahkan ke dalam kategori
        foreach ($transaksi as $t) {
            if (empty($t->tgl_kembali)){
                $transaksiBerlangsung[] = $t;
            }
        }
        return view('transaksi.index', compact('transaksiBerlangsung'));
    }

    public function selesai()
    {
        $transaksiSelesai = [];

        $transaksi = DetailTransaksi::join('buku', 'buku.id', '=', 'detail_transaksi.idbuku')
        ->leftJoin('peminjaman', 'peminjaman.idtransaksi', '=', 'detail_transaksi.idtransaksi')
        ->leftJoin('anggota', 'anggota.noktp', '=', 'peminjaman.noktp')
        ->leftJoin('petugas', 'petugas.idpetugas', '=', 'detail_transaksi.idpetugas')
        ->select('detail_transaksi.*', 'buku.judul AS judul_buku', 'peminjaman.tgl_pinjam AS tanggal_peminjaman', 'anggota.nama AS nama', 'petugas.nama AS namapetugas', 'buku.isbn AS isbn')
        ->orderBy('detail_transaksi.idtransaksi', 'asc')
        ->get();

        foreach ($transaksi as $t) {
            if (!empty($t->tgl_kembali)){
                $transaksiSelesai[] = $t;
            }
        }

        return view('transaksi.selesai', compact('transaksiSelesai'));
    }

    public function berlangsung()
    {
        $transaksiBerlangsung = [];

        $transaksi = DetailTransaksi::join('buku', 'buku.id', '=', 'detail_transaksi.idbuku')
        ->leftJoin('peminjaman', 'peminjaman.idtransaksi', '=', 'detail_transaksi.idtransaksi')
        ->leftJoin('anggota', 'anggota.noktp', '=', 'peminjaman.noktp')
        ->leftJoin('petugas', 'petugas.idpetugas', '=', 'detail_transaksi.idpetugas')
        ->select('detail_transaksi.*', 'buku.judul AS judul_buku', 'peminjaman.tgl_pinjam AS tanggal_peminjaman', 'anggota.nama AS nama', 'petugas.nama AS namapetugas', 'buku.isbn AS isbn')
        ->orderBy('detail_transaksi.idtransaksi', 'asc')
        ->get();

        // Hitung denda dan pisahkan ke dalam kategori
        foreach ($transaksi as $t) {
            if (($t->tgl_kembali) == null){
                $transaksiBerlangsung[] = $t;
            }
        }
        return view('transaksi.berlangsung', compact('transaksiBerlangsung'));
    }


    public function melebihi()
    {
        $transaksiMelebihiTanggalKembali = DetailTransaksi::leftJoin('buku', 'buku.id', '=', 'detail_transaksi.idbuku')
            ->leftJoin('peminjaman', 'peminjaman.idtransaksi', '=', 'detail_transaksi.idtransaksi')
            ->leftJoin('anggota', 'anggota.noktp', '=', 'peminjaman.noktp')
            ->leftJoin('petugas', 'petugas.idpetugas', '=', 'detail_transaksi.idpetugas')
            ->select('detail_transaksi.*', 'buku.judul AS judul_buku', 'peminjaman.tgl_pinjam AS tanggal_peminjaman', 'anggota.nama AS nama', 'petugas.nama AS namapetugas', 'buku.isbn AS isbn')
            ->whereNotNull('detail_transaksi.tgl_kembali')
            ->where('detail_transaksi.denda', '>', 0)
            ->orderBy('detail_transaksi.idtransaksi', 'asc')
            ->get();
    
        return view('transaksi.melebihi', compact('transaksiMelebihiTanggalKembali'));
    }
    

    public function add(Request $request): RedirectResponse
    {
        $request->validate([
            'noktp' => 'required|numeric', // Contoh validasi untuk Nomor KTP
            'buku.*' => 'required|numeric', // Validasi untuk setiap ID Buku dalam array
            'tgl_pinjam' => 'required|date', // Validasi untuk Tanggal Pinjam
            'idpetugas' => 'required|numeric', // Validasi untuk ID Petugas
        ], [
            'noktp.required' => 'Nomor KTP Anggota wajib diisi.',
            'noktp.numeric' => 'Nomor KTP Anggota harus berupa angka.',
            'buku.*.required' => 'Setiap ID Buku wajib diisi.',
            'buku.*.numeric' => 'Setiap ID Buku harus berupa angka.',
            'tgl_pinjam.required' => 'Tanggal Pinjam wajib diisi.',
            'tgl_pinjam.date' => 'Tanggal Pinjam harus berupa tanggal yang valid.',
            'idpetugas.required' => 'ID Petugas wajib diisi.',
            'idpetugas.numeric' => 'ID Petugas harus berupa angka.',
        ]);

        $ids_buku = $request->input('buku');

        if (count($ids_buku) > 2) {
            return redirect()->route('form-peminjaman')->with('error', 'Peminjaman harus mencakup minimal 2 buku.');
        }

        try {
            // Memeriksa stok buku
            $isAllAvailable = true;
            foreach ($ids_buku as $id_buku) {
                $buku = Buku::find($id_buku);

                if (!$buku || $buku->stok_tersedia <= 0) {
                    $isAllAvailable = false;
                    break;
                }
            }

            if (!$isAllAvailable) {
                DB::rollBack();
                return redirect()->route('transaksi.form-peminjaman')->with('error', 'Beberapa buku tidak tersedia.');
            }

            // Pastikan anggota tidak memiliki peminjaman aktif
            $existingPeminjaman = Peminjaman::where('noktp', $request->input('noktp'))
                ->whereHas('detailTransaksi', function ($query) {
                    $query->whereNull('tgl_kembali');
                })
                ->exists();

            if ($existingPeminjaman) {
                DB::rollBack();
                return redirect()->route('transaksi.form-peminjaman')->with('error', 'Anggota masih memiliki peminjaman aktif.');
            }
            $peminjaman = new Peminjaman();
            $peminjaman->noktp = $request->input('noktp');
            $peminjaman->tgl_pinjam = $request->input('tgl_pinjam');
            $peminjaman->idpetugas = $request->input('idpetugas');
            $peminjaman->save();

            $lastTransaction = Peminjaman::latest('idtransaksi')->first();

            foreach ($ids_buku as $id_buku) {
                // ...

                // Menyimpan detail transaksi
                $detail_transaksi = new DetailTransaksi();
                $detail_transaksi->idtransaksi = $lastTransaction->idtransaksi;
                $detail_transaksi->idbuku = $id_buku;
                $detail_transaksi->idpetugas = $request->input('idpetugas');
                $detail_transaksi->save();

                // ...

                // Mengurangi stok buku yang dipinjam
                $buku = Buku::find($id_buku);

                if ($buku->stok_tersedia > 0) {
                    $buku->stok_tersedia -= 1;
                    $buku->save();
                } else {
                    DB::rollBack();
                    dd('Stok buku tidak mencukupi');
                    return redirect()->route('transaksi.form-peminjaman')->with('error', 'Stok buku tidak mencukupi.');
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Peminjaman berhasil.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd('Peminjaman gagal: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Peminjaman gagal.');
        }
    }

    public function daftarTransaksi()
    {
        $daftarTransaksi = [];

        $transaksi = DetailTransaksi::join('buku', 'buku.id', '=', 'detail_transaksi.idbuku')
        ->leftJoin('peminjaman', 'peminjaman.idtransaksi', '=', 'detail_transaksi.idtransaksi')
        ->leftJoin('anggota', 'anggota.noktp', '=', 'peminjaman.noktp')
        ->leftJoin('petugas', 'petugas.idpetugas', '=', 'detail_transaksi.idpetugas')
        ->select('detail_transaksi.*', 'buku.judul AS judul_buku', 'peminjaman.tgl_pinjam AS tanggal_peminjaman', 'anggota.nama AS nama', 'petugas.nama AS namapetugas', 'buku.isbn AS isbn')
        ->orderBy('detail_transaksi.idtransaksi', 'asc')
        ->get();

        // Hitung denda dan pisahkan ke dalam kategori
        foreach ($transaksi as $t) {
            if (($t->tgl_kembali) == null){
                $daftarTransaksi[] = $t;
            }
        }
        return view('transaksi.daftar-transaksi', compact('daftarTransaksi'));
    }

    public function update(Request $request, int $idtransaksi)
    {
        $request->validate([
            'tgl_kembali' => 'required|date', // Validasi untuk Tanggal Kembali
        ], [
            'tgl_kembali.required' => 'Tanggal Kembali wajib diisi.',
            'tgl_kembali.date' => 'Tanggal Kembali harus berupa tanggal yang valid.',
        ]);
    
        $transaksi = DetailTransaksi::find($idtransaksi);
    
        // Menghitung selisih hari antara tanggal pengembalian dan tanggal peminjaman menggunakan Carbon
        $tanggalPeminjaman = Carbon::parse($transaksi->tgl_pinjam);
        $tanggalKembali = Carbon::parse($request->tgl_kembali);
        $selisihHari = $tanggalKembali->diffInDays($tanggalPeminjaman);
    
        // Menghitung denda jika selisih hari lebih dari 14
        if ($selisihHari > 14) {
            $denda = (($selisihHari - 14) * 1000) - 2000;
        } else {
            $denda = 0; // Tidak ada denda jika kurang dari atau sama dengan 14 hari
        }
    
        // Menyimpan tanggal kembali dan denda ke dalam model
        $transaksi->tgl_kembali = $request->tgl_kembali;
        $transaksi->denda = $denda;
        $transaksi->save();
    
        return redirect()->route("transaksi.daftar-transaksi")->with('success', 'Data pengembalian berhasil diperbarui.');
    }
    
        
    

    public function formPengembalian($idtransaksi) {
        $transaksi = DetailTransaksi::where('idtransaksi', $idtransaksi)->first(); // Mengambil data transaksi berdasarkan ID
        return view('transaksi.form-pengembalian', ['transaksi' => $transaksi]);
    }
    
    

}
