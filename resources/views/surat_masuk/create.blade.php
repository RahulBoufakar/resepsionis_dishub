@extends('layouts.app')

@section('title', 'Tambah Surat Masuk')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-soft p-3">
            <form action="{{ route('surat-masuk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" name="no_surat" value="{{ old('no_surat') }}" class="form-control @error('no_surat') is-invalid @enderror" required>
                    @error('no_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Surat</label>
                    <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', date('Y-m-d')) }}" class="form-control @error('tanggal_surat') is-invalid @enderror" required>
                    @error('tanggal_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Pengirim</label>
                    <input type="text" name="pengirim" value="{{ old('pengirim') }}" class="form-control @error('pengirim') is-invalid @enderror" required>
                    @error('pengirim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Perihal</label>
                    <textarea name="perihal" class="form-control @error('perihal') is-invalid @enderror" rows="3" required>{{ old('perihal') }}</textarea>
                    @error('perihal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">File (PDF/JPG/PNG)</label>
                    <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" class="form-control @error('file') is-invalid @enderror" required>
                    @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary">Batal</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection