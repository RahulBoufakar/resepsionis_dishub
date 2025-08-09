<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArsipController extends Controller
{

    public function index(Request $request)
    {
        $suratMasuk = SuratMasuk::select(
                'id', 'no_surat', 'tanggal_surat', 'pengirim', 'perihal', 'file',
                DB::raw("'masuk' as jenis")
            );

        $suratKeluar = SuratKeluar::select(
                'id', 'no_surat', 'tanggal_surat', 'penerima as pengirim', 'perihal', 'file',
                DB::raw("'keluar' as jenis")
            );

        // Gabungkan query dengan unionAll
        $query = $suratMasuk->unionAll($suratKeluar);

        // Bungkus hasil union dalam subquery biar bisa paginate
        $arsip = DB::table(DB::raw("({$query->toSql()}) as arsip"))
            ->mergeBindings($query->getQuery()) // penting untuk binding parameter
            ->where('tanggal_surat', '<', Carbon::now()->subYear()->endOfYear()->toDateString())
            ->when($request->no_surat, function ($q) use ($request) {
                $q->where('no_surat', 'like', '%' . $request->no_surat . '%');
            })
            ->when($request->start_date, function ($q) use ($request) {
                $q->where('tanggal_surat', '>=', $request->start_date);
            })
            ->when($request->end_date, function ($q) use ($request) {
                $q->where('tanggal_surat', '<=', $request->end_date);
            })
            ->orderBy('tanggal_surat', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('arsip.index', compact('arsip'));
    }

}
