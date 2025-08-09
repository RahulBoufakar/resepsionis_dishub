<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Tampilkan dashboard stats untuk admin.
     */
    public function dashboard()
    {
        // counts
        $totalSuratMasuk = SuratMasuk::count();
        $totalSuratKeluar = SuratKeluar::count();
        $totalUsersViewer = User::where('role', 'viewer')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        // arsip > 1 tahun (gabungan)
        $batasTanggal = Carbon::now()->subYear();
        $arsipMasuk = SuratMasuk::where('tanggal_surat', '<', $batasTanggal)->count();
        $arsipKeluar = SuratKeluar::where('tanggal_surat', '<', $batasTanggal)->count();
        $totalArsip = $arsipMasuk + $arsipKeluar;

        // latest items
        $latestMasuk = SuratMasuk::latest()->take(5)->get();
        $latestKeluar = SuratKeluar::latest()->take(5)->get();

        // data bulanan (12 bulan terakhir) untuk chart
        $labels = [];
        $masukData = [];
        $keluarData = [];

        for ($i = 11; $i >= 0; $i--) {
            $dt = Carbon::now()->subMonths($i);
            $labels[] = $dt->format('M Y');

            $start = $dt->copy()->startOfMonth();
            $end = $dt->copy()->endOfMonth();

            $masukCount = SuratMasuk::whereBetween('tanggal_surat', [$start->toDateString(), $end->toDateString()])->count();
            $keluarCount = SuratKeluar::whereBetween('tanggal_surat', [$start->toDateString(), $end->toDateString()])->count();

            $masukData[] = $masukCount;
            $keluarData[] = $keluarCount;
        }

        return view('admin.dashboard', [
            'totalSuratMasuk' => $totalSuratMasuk,
            'totalSuratKeluar' => $totalSuratKeluar,
            'totalUsersViewer' => $totalUsersViewer,
            'totalAdmins' => $totalAdmins,
            'totalArsip' => $totalArsip,
            'latestMasuk' => $latestMasuk,
            'latestKeluar' => $latestKeluar,
            'labels' => $labels,
            'masukData' => $masukData,
            'keluarData' => $keluarData,
        ]);
    }
}