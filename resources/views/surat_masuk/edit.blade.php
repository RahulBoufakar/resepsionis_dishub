@extends('layouts.app')

@section('title', 'Edit Surat Masuk')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-soft p-3">
            <h5>Edit Surat Masuk</h5>
            <form action="{{ route('surat-masuk.update', $suratMasuk->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" name="no_surat" value="{{ old('no_surat', $suratMasuk->no_surat) }}" class="form-control @error('no_surat') is-invalid @enderror" required>
                    @error('no_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Surat</label>
                    <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', $suratMasuk->tanggal_surat) }}" class="form-control @error('tanggal_surat') is-invalid @enderror" required>
                    @error('tanggal_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Pengirim</label>
                    <input type="text" name="pengirim" value="{{ old('pengirim', $suratMasuk->pengirim) }}" class="form-control @error('pengirim') is-invalid @enderror" required>
                    @error('pengirim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Perihal</label>
                    <textarea name="perihal" class="form-control @error('perihal') is-invalid @enderror" rows="3" required>{{ old('perihal', $suratMasuk->perihal) }}</textarea>
                    @error('perihal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Ganti File (kosongkan jika tidak ingin mengganti)</label>
                    <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" class="form-control @error('file') is-invalid @enderror">
                    @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror

                    @if($suratMasuk->file)
                        <div class="mt-2">
                            <small class="text-muted">File sekarang:</small>
                            <a href="{{ asset('storage/'.$suratMasuk->file) }}" target="_blank" class="d-block">{{ basename($suratMasuk->file) }}</a>
                        </div>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary">Batal</a>
                    <button class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection