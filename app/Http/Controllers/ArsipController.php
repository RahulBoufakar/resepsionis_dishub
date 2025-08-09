<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Carbon\Carbon;

class ArsipController extends Controller
{
    public function index()
    {
        $batasTanggal = Carbon::now()->subYear(); // 1 tahun ke belakang

        $suratMasuk = SuratMasuk::where('tanggal_surat', '<', $batasTanggal)->get();
        $suratKeluar = SuratKeluar::where('tanggal_surat', '<', $batasTanggal)->get();

        // Gabungkan dan urutkan berdasarkan tanggal
        $arsip = collect($suratMasuk)
            ->merge($suratKeluar)
            ->sortByDesc('tanggal_surat');

        return view('arsip.index', compact('arsip'));
    }
}