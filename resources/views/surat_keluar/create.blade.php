@extends('layouts.app')

@section('title', 'Tambah Surat Keluar')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Surat Keluar</h1>

    <form action="{{ route('surat-keluar.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>No Surat</label>
            <input type="text" name="no_surat" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Surat</label>
            <input type="date" name="tanggal_surat" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tujuan</label>
            <input type="text" name="tujuan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Perihal</label>
            <input type="text" name="perihal" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>File Surat (PDF)</label>
            <input type="file" name="file" class="form-control" accept="application/pdf">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('surat-keluar.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
