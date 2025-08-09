@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row g-3">
    <div class="col-md-3">
        <div class="card card-soft p-3">
            <h6 class="mb-1">Surat Masuk</h6>
            <h3 class="mb-0">{{ $totalSuratMasuk }}</h3>
            <small class="text-muted">Total surat masuk</small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-soft p-3">
            <h6 class="mb-1">Surat Keluar</h6>
            <h3 class="mb-0">{{ $totalSuratKeluar }}</h3>
            <small class="text-muted">Total surat keluar</small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-soft p-3">
            <h6 class="mb-1">Users (Viewer)</h6>
            <h3 class="mb-0">{{ $totalUsersViewer }}</h3>
            <small class="text-muted">Akun viewer</small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-soft p-3">
            <h6 class="mb-1">Arsip > 1 Tahun</h6>
            <h3 class="mb-0">{{ $totalArsip }}</h3>
            <small class="text-muted">Surat yang sudah diarsipkan</small>
        </div>
    </div>
</div>

<div class="row mt-4 g-3">
    <div class="col-lg-8">
        <div class="card card-soft p-3">
            <h5>Aktivitas Bulanan (12 bulan terakhir)</h5>
            <canvas id="suratChart" height="120"></canvas>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card card-soft p-3 mb-3">
            <h6>Admin</h6>
            <p class="mb-0"><strong>{{ $totalAdmins }}</strong> akun admin</p>
        </div>

        <div class="card card-soft p-3">
            <h6>Terakhir - Surat Masuk</h6>
            <ul class="list-group list-group-flush">
                @forelse($latestMasuk as $m)
                    <li class="list-group-item">
                        <strong>{{ $m->no_surat }}</strong><br>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($m->tanggal_surat)->format('d-m-Y') }} — {{ Str::limit($m->perihal, 50) }}</small>
                    </li>
                @empty
                    <li class="list-group-item">Tidak ada surat masuk</li>
                @endforelse
            </ul>
        </div>

        <div class="card card-soft p-3 mt-3">
            <h6>Terakhir - Surat Keluar</h6>
            <ul class="list-group list-group-flush">
                @forelse($latestKeluar as $k)
                    <li class="list-group-item">
                        <strong>{{ $k->no_surat }}</strong><br>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($k->tanggal_surat)->format('d-m-Y') }} — {{ Str::limit($k->perihal, 50) }}</small>
                    </li>
                @empty
                    <li class="list-group-item">Tidak ada surat keluar</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const labels = {!! json_encode($labels) !!};
    const masukData = {!! json_encode($masukData) !!};
    const keluarData = {!! json_encode($keluarData) !!};

    const ctx = document.getElementById('suratChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Surat Masuk',
                    data: masukData,
                    tension: 0.3,
                    borderWidth: 2,
                    pointRadius: 4,
                    backgroundColor: 'rgba(55,84,211,0.08)',
                    borderColor: 'rgba(55,84,211,0.85)',
                    fill: true
                },
                {
                    label: 'Surat Keluar',
                    data: keluarData,
                    tension: 0.3,
                    borderWidth: 2,
                    pointRadius: 4,
                    backgroundColor: 'rgba(32,201,151,0.08)',
                    borderColor: 'rgba(32,201,151,0.9)',
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: { beginAtZero: true, precision: 0 }
            }
        }
    });
</script>
@endsection
