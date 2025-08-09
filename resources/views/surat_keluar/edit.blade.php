@extends('layouts.app')

@section('title', 'Edit Surat Keluar')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Surat Keluar</h1>

    <form action="{{ route('surat-keluar.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>No Surat</label>
            <input type="text" name="no_surat" value="{{ $surat->no_surat }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Surat</label>
            <input type="date" name="tanggal_surat" value="{{ $surat->tanggal_surat }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tujuan</label>
            <input type="text" name="tujuan" value="{{ $surat->tujuan }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Perihal</label>
            <input type="text" name="perihal" value="{{ $surat->perihal }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>File Surat (PDF)</label>
            @if($surat->file)
                <iframe src="{{ asset('storage/surat_keluar/' . $surat->file) }}" width="100%" height="400"></iframe>
            @endif
            <input type="file" name="file" class="form-control mt-2" accept="application/pdf">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('surat-keluar.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
