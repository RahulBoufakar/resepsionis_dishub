@extends('layouts.app')

@section('title', 'Surat Masuk')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('surat-masuk.create') }}" class="btn btn-primary">
            Tambah Surat Masuk
        </a>
    </div>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Daftar Surat Masuk</h5>
        <form method="GET" action="{{ route('surat-masuk.index') }}" class="d-flex">
            <select name="year" class="form-select me-2" onchange="this.form.submit()">
                @foreach($years as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endforeach
            </select>
            <noscript><button type="submit" class="btn btn-primary">Filter</button></noscript>
        </form>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Surat</th>
                    <th>Tanggal Surat</th>
                    <th>Pengirim</th>
                    <th>Perihal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($surat as $index => $item)
                    <tr>
                        <td>{{ $loop->iteration + ($surat->currentPage() - 1) * $surat->perPage() }}</td>
                        <td>{{ $item->no_surat }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d-m-Y') }}</td>
                        <td>{{ $item->pengirim }}</td>
                        <td>{{ $item->perihal }}</td>
                        <td>
                            <a href="{{ route('surat-masuk.show', $item->id) }}" class="btn btn-info btn-sm">Lihat</a>
                            <a href="{{ route('surat-masuk.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('surat-masuk.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus surat ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data surat masuk</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $surat->withQueryString()->links() }}
    </div>
</div>
@endsection
