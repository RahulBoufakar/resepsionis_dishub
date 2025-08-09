@extends('layouts.app')

@section('title', 'Surat Keluar')

@section('content')
<div class="container">

    {{-- Filter --}}
    <form method="GET" action="{{ route('surat-keluar.index') }}" class="row g-3 mb-3">
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

    <a href="{{ route('surat-keluar.create') }}" class="btn btn-success mb-3">+ Tambah Surat Keluar</a>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>No Surat</th>
                    <th>Tanggal Surat</th>
                    <th>Tujuan</th>
                    <th>Perihal</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($surat as $item)
                <tr>
                    <td>{{ $item->no_surat }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d-m-Y') }}</td>
                    <td>{{ $item->tujuan }}</td>
                    <td>{{ $item->perihal }}</td>
                    <td>
                        @if($item->file)
                            <a href="{{ asset('storage/surat_keluar/' . $item->file) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                        @else
                            <span class="text-muted">Tidak ada</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('surat-keluar.show', $item->id) }}" class="btn btn-sm btn-primary">Detail</a>
                        <a href="{{ route('surat-keluar.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('surat-keluar.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $surat->links() }}
</div>
@endsection