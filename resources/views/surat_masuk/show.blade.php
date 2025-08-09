@extends('layouts.app')

@section('title', 'Detail Surat Masuk')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Detail Surat Masuk</h4>
    </div>
    <div class="card-body">
        <p><strong>No Surat:</strong> {{ $surat->no_surat }}</p>
        <p><strong>Tanggal Surat:</strong> {{ $surat->tanggal_surat }}</p>
        <p><strong>Pengirim:</strong> {{ $surat->pengirim }}</p>
        <p><strong>Perihal:</strong> {{ $surat->perihal }}</p>

        <h5 class="mt-4">Preview Dokumen:</h5>
        <iframe
            src="{{ asset('pdfjs/web/viewer.html') }}?file={{ urlencode(route('suratMasuk.preview', $surat->file)) }}"
            width="100%"
            height="600px"
            style="border:none;">
        </iframe>
    </div>
</div>
@endsection