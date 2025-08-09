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
        $query = SuratMasuk::query();

        if ($request->filled('no_surat')) {
            $query->where('no_surat', 'like', '%' . $request->no_surat . '%');
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_surat', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('tanggal_surat', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('tanggal_surat', '<=', $request->end_date);
        }

        $surat = $query->latest()->paginate(10)->withQueryString();

        return view('surat_masuk.index', compact('surat'));
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