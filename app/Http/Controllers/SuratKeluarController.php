<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{

    public function index(Request $request)
    {
        $query = SuratKeluar::query();

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

        return view('surat_keluar.index', compact('surat'));
    }



    public function create()
    {
        return view('surat_keluar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_surat' => 'required|unique:surat_keluars',
            'tanggal_surat' => 'required|date',
            'penerima' => 'required',
            'perihal' => 'required',
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $filePath = $request->file('file')->store('surat_keluar', 'public');

        SuratKeluar::create([
            'no_surat' => $request->no_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'penerima' => $request->penerima,
            'perihal' => $request->perihal,
            'file' => $filePath,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil ditambahkan.');
    }

    public function show(SuratKeluar $suratKeluar)
    {
        return view('surat_keluar.show', compact('suratKeluar'));
    }

    public function edit(SuratKeluar $suratKeluar)
    {
        return view('surat_keluar.edit', compact('suratKeluar'));
    }

    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        $request->validate([
            'no_surat' => 'required|unique:surat_keluars,no_surat,' . $suratKeluar->id,
            'tanggal_surat' => 'required|date',
            'penerima' => 'required',
            'perihal' => 'required',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $filePath = $suratKeluar->file;
        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($suratKeluar->file);
            $filePath = $request->file('file')->store('surat_keluar', 'public');
        }

        $suratKeluar->update([
            'no_surat' => $request->no_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'penerima' => $request->penerima,
            'perihal' => $request->perihal,
            'file' => $filePath,
        ]);

        return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil diperbarui.');
    }

    public function destroy(SuratKeluar $suratKeluar)
    {
        Storage::disk('public')->delete($suratKeluar->file);
        $suratKeluar->delete();
        return redirect()->route('surat-keluar.index')->with('success', 'Surat Keluar berhasil dihapus.');
    }
}
