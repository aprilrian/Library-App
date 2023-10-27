<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Anggota;

class AnggotaController extends Controller
{
    //
    public function showAll()
    {
        $members = Anggota::where('status', 0)->get();
        return view('verifikasi.verifikasi', ['anggota' => $members]);
    }

    public function verifikasi(Request $request) {
        $noktp = $request->input('noktp');

        $anggota = Anggota::where('noktp', $noktp)->first();

        if ($anggota) {
            $anggota->status = 1;
            $anggota->save();
            return redirect()->back()->with('success', 'Anggota berhasil diverifikasi.');
        } else {
            return redirect()->back()->with('error', 'Anggota tidak ditemukan.');
        }
    }
}
