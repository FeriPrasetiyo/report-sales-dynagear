@extends('layouts.app')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold">Dashboard Sales Report</h3>

    <p class="text-muted mb-0">
        Selamat datang, <strong>{{ Auth::user()->name }}</strong>
    </p>

    <form method="GET" class="card card-body border-0 shadow-sm mt-3">
        <div class="row">

            <div class="col-md-3 mb-2">
                <select name="month" class="form-select">
                    <option value="">Semua Bulan</option>

                    @foreach(range(1,12) as $m)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-2">
                <select name="year" class="form-select">
                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-2 mb-2">
                <button class="btn btn-primary w-100">
                    Filter
                </button>
            </div>

            <div class="col-md-2 mb-2">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100">
                    Reset
                </a>
            </div>

        </div>
    </form>
</div>

@if(Auth::user()->role == 'sales' && $targetSales)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">

        <h5 class="fw-bold mb-3">
            Target Bulan Ini
        </h5>

        <div class="row">

            <div class="col-md-4">
                <p class="text-muted mb-1">Target</p>
                <h4>
                    Rp {{ number_format($targetSales->target_amount, 0, ',', '.') }}
                </h4>
            </div>

            <div class="col-md-4">
                <p class="text-muted mb-1">Deal Saat Ini</p>
                <h4 class="text-success">
                    Rp {{ number_format($dealAmount, 0, ',', '.') }}
                </h4>
            </div>

            <div class="col-md-4">
                <p class="text-muted mb-1">Progress</p>
                <h4>
                    {{ $progressPercent }}%
                </h4>
            </div>

        </div>

        <div class="progress mt-3" style="height:25px">
            <div class="progress-bar bg-success"
                 role="progressbar"
                 style="width: {{ min($progressPercent, 100) }}%">
                {{ $progressPercent }}%
            </div>
        </div>

    </div>
</div>
@endif

<div class="row">

    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Total Report</p>
                <h3 class="fw-bold">{{ $totalReport }}</h3>
                <span class="badge bg-primary">Semua Data</span>
            </div>
        </div>
    </div>

    @if(Auth::user()->role != 'sales')
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Total Sales</p>
                <h3 class="fw-bold">{{ $totalSales }}</h3>
                <span class="badge bg-dark">User Sales</span>
            </div>
        </div>
    </div>
    @endif

    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Deal</p>
                <h3 class="fw-bold text-success">{{ $totalDeal }}</h3>
                <span class="badge bg-success">Berhasil</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">No Deal</p>
                <h3 class="fw-bold text-danger">{{ $totalNoDeal }}</h3>
                <span class="badge bg-danger">Tidak Deal</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Pending</p>
                <h3 class="fw-bold text-warning">{{ $totalPending }}</h3>
                <span class="badge bg-warning text-dark">Menunggu</span>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Total Nilai Deal</p>
                <h3 class="fw-bold">
                    Rp {{ number_format($nilaiDeal, 0, ',', '.') }}
                </h3>
                <span class="badge bg-success">Revenue Deal</span>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Follow Up Hari Ini</p>
                <h3 class="fw-bold text-primary">{{ $followUpToday }}</h3>
                <span class="badge bg-primary">Reminder</span>
            </div>
        </div>
    </div>

</div>

<div class="row mt-3">

    <div class="col-lg-8 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold">
                Trend Deal Bulanan
            </div>

            <div class="card-body">
                <canvas id="lineChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold">
                Statistik Deal
            </div>

            <div class="card-body text-center" style="height:280px">
                <canvas id="dealChart"></canvas>
            </div>
        </div>
    </div>

</div>

@if(Auth::user()->role != 'sales')
<div class="card border-0 shadow-sm mb-3">

    <div class="card-header bg-white fw-bold">
        Grafik Deal Per Sales
    </div>

    <div class="card-body">
        <canvas id="salesChart" height="100"></canvas>
    </div>

</div>
@endif

@if(Auth::user()->role != 'sales')
<div class="card border-0 shadow-sm mb-3">

    <div class="card-header bg-white fw-bold">
        Top Progress Target Sales
    </div>

    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="80">Rank</th>
                        <th>Sales</th>
                        <th>Target</th>
                        <th>Deal</th>
                        <th width="250">Progress</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($targetRanking as $index => $item)
                        <tr>
                            <td>
                                @if($index == 0)
                                    🥇
                                @elseif($index == 1)
                                    🥈
                                @elseif($index == 2)
                                    🥉
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </td>

                            <td>{{ $item['name'] }}</td>

                            <td>
                                Rp {{ number_format($item['target'], 0, ',', '.') }}
                            </td>

                            <td>
                                Rp {{ number_format($item['deal'], 0, ',', '.') }}
                            </td>

                            <td>
                                <div class="progress" style="height:24px">
                                    <div class="progress-bar bg-success"
                                         role="progressbar"
                                         style="width: {{ min($item['progress'], 100) }}%">
                                        {{ $item['progress'] }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada target sales.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endif

<div class="card border-0 shadow-sm mt-3">

    <div class="card-header bg-white fw-bold">
        Report Terbaru
    </div>

    <div class="card-body table-responsive">

        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Tanggal</th>
                    <th>Sales</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($latestReports as $report)
                    <tr>
                        <td>{{ $report->tanggal }}</td>
                        <td>{{ $report->sales->name ?? '-' }}</td>
                        <td>{{ $report->customer_name }}</td>
                        <td>
                            Rp {{ number_format($report->total, 0, ',', '.') }}
                        </td>
                        <td>
                            @if($report->status == 'deal')
                                <span class="badge bg-success">Deal</span>
                            @elseif($report->status == 'no_deal')
                                <span class="badge bg-danger">No Deal</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('sales-reports.show', $report->id) }}"
                               class="btn btn-sm btn-info">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Belum ada report.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const donut = document.getElementById('dealChart');

if (donut) {
    new Chart(donut, {
        type: 'doughnut',
        data: {
            labels: ['Deal', 'No Deal', 'Pending'],
            datasets: [{
                data: [
                    {{ $totalDeal }},
                    {{ $totalNoDeal }},
                    {{ $totalPending }}
                ],
                backgroundColor: [
                    '#198754',
                    '#dc3545',
                    '#ffc107'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

const line = document.getElementById('lineChart');

if (line) {
    new Chart(line, {
        type: 'line',
        data: {
            labels: [
                'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
            ],
            datasets: [
                {
                    label: 'Deal',
                    data: @json($monthlyDeals),
                    borderColor: '#198754',
                    backgroundColor: '#198754',
                    tension: 0.4
                },
                {
                    label: 'No Deal',
                    data: @json($monthlyNoDeals),
                    borderColor: '#dc3545',
                    backgroundColor: '#dc3545',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

const salesChart = document.getElementById('salesChart');

if (salesChart) {
    new Chart(salesChart, {
        type: 'bar',
        data: {
            labels: @json($salesChartLabels),
            datasets: [{
                label: 'Nilai Deal',
                data: @json($salesChartData),
                backgroundColor: [
                    '#0d6efd',
                    '#198754',
                    '#ffc107',
                    '#dc3545',
                    '#6f42c1',
                    '#20c997',
                    '#fd7e14'
                ],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
</script>

@endsection