@extends('layouts.app')

@section('title', 'Detail Surat Keluar')

@section('content')
<div class="container">

    <table class="table">
        <tr>
            <th>No Surat</th>
            <td>{{ $surat->no_surat }}</td>
        </tr>
        <tr>
            <th>Tanggal Surat</th>
            <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <th>Tujuan</th>
            <td>{{ $surat->tujuan }}</td>
        </tr>
        <tr>
            <th>Perihal</th>
            <td>{{ $surat->perihal }}</td>
        </tr>
        <tr>
            <th>File</th>
            <td>
                @if($surat->file)
                    <iframe src="{{ asset('storage/surat_keluar/' . $surat->file) }}" width="100%" height="600"></iframe>
                @else
                    <span class="text-muted">Tidak ada file</span>
                @endif
            </td>
        </tr>
    </table>

    <a href="{{ route('surat-keluar.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
