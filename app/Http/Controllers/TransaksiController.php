<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DetailTransaksi;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $transaksiMelebihiTanggalKembali = [];

        $transaksi = DetailTransaksi::join('buku', 'buku.id', '=', 'detail_transaksi.idbuku')
            ->join('peminjaman', 'peminjaman.idtransaksi', '=', 'detail_transaksi.idtransaksi')
            ->join('anggota', 'anggota.noktp', '=', 'peminjaman.noktp')
            ->join('petugas', 'petugas.idpetugas', '=', 'detail_transaksi.idpetugas')
            ->select('detail_transaksi.*', 'buku.judul AS judul_buku', 'peminjaman.tgl_pinjam AS tanggal_peminjaman', 'anggota.nama AS nama', 'petugas.nama AS namapetugas', 'buku.isbn AS isbn')
            ->whereNotNull('detail_transaksi.tgl_kembali') // Hanya ambil transaksi yang memiliki tanggal kembali
            ->orderBy('detail_transaksi.idtransaksi', 'asc')
            ->get();

        // Hitung denda dan pisahkan ke dalam kategori
        foreach ($transaksi as $t) {
            $tanggalPeminjaman = new \DateTime($t->tanggal_peminjaman);
            $tanggalKembali = new \DateTime($t->tgl_kembali);
            $selisihHari = $tanggalPeminjaman->diff($tanggalKembali)->days;

            if ($selisihHari > 14) {
                $denda = ($selisihHari - 14) * 1000;
                $t->denda = $denda;
                $transaksiMelebihiTanggalKembali[] = $t;
            }
        }

        return view('transaksi.melebihi', compact('transaksiMelebihiTanggalKembali'));
    }

    public function add(Request $request): RedirectResponse
    {
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

            return redirect()->route('transaksi.index')->with('success', 'Peminjaman berhasil');
        } catch (\Exception $e) {
            DB::rollBack();
            dd('Peminjaman gagal: ' . $e->getMessage());
            return redirect()->route('transaksi.form-peminjaman')->with('error', 'Peminjaman gagal.');
        }
    }
}
