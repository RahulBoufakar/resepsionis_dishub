@extends('layouts.app')

@section('title', 'Arsip Surat')

@section('content')
<div class="container">
    <h1 class="mb-4">Arsip Surat</h1>

    <form method="GET" action="{{ route('arsip.index') }}" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="no_surat" value="{{ request('no_surat') }}" class="form-control" placeholder="No Surat">
        </div>
        <div class="col-md-3">
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Surat</th>
                    <th>Tanggal Surat</th>
                    <th>Pengirim / Penerima</th>
                    <th>Perihal</th>
                    <th>Jenis Surat</th>
                    <th>File</th>
                </tr>
            </thead>
            <tbody>
                @forelse($arsip as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->no_surat }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d-m-Y') }}</td>
                    <td>{{ $item->pengirim ?? $item->penerima }}</td>
                    <td>{{ $item->perihal }}</td>
                    <td>{{ ucfirst($item->jenis) }}</td>
                    <td>
                        @if($item->file)
                            <a href="{{ asset('storage/' . $item->file) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data arsip</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $arsip->links() }}
</div>
@endsection