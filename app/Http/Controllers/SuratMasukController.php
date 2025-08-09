<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', now()->year); // default tahun sekarang

        $start = now()->setYear($year)->startOfYear()->format('Y-m-d');
        $end   = now()->setYear($year)->endOfYear()->format('Y-m-d');

        $surat = SuratMasuk::latest('tanggal_surat')
            ->whereBetween('tanggal_surat', [$start, $end])
            ->paginate(10);

        // Ambil daftar tahun unik dari data surat masuk
        $years = SuratMasuk::selectRaw('YEAR(tanggal_surat) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('surat_masuk.index', compact('surat', 'years', 'year'));
    }


    public function create()
    {
        return view('surat_masuk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_surat' => 'required|unique:surat_masuks',
            'tanggal_surat' => 'required|date',
            'pengirim' => 'required',
            'perihal' => 'required',
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $filePath = $request->file('file')->store('surat_masuk', 'public');

        SuratMasuk::create([
            'no_surat' => $request->no_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'pengirim' => $request->pengirim,
            'perihal' => $request->perihal,
            'file' => $filePath,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    public function show(SuratMasuk $suratMasuk)
    {
        return view('surat_masuk.show', ['surat' => $suratMasuk]);
    }

    public function edit(SuratMasuk $suratMasuk)
    {
        return view('surat_masuk.edit', compact('suratMasuk'));
    }

    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $request->validate([
            'no_surat' => 'required|unique:surat_masuks,no_surat,' . $suratMasuk->id,
            'tanggal_surat' => 'required|date',
            'pengirim' => 'required',
            'perihal' => 'required',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $filePath = $suratMasuk->file;
        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($suratMasuk->file);
            $filePath = $request->file('file')->store('surat_masuk', 'public');
        }

        $suratMasuk->update([
            'no_surat' => $request->no_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'pengirim' => $request->pengirim,
            'perihal' => $request->perihal,
            'file' => $filePath,
        ]);

        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil diperbarui.');
    }

    public function destroy(SuratMasuk $suratMasuk)
    {
        Storage::disk('public')->delete($suratMasuk->file);
        $suratMasuk->delete();
        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil dihapus.');
    }
}