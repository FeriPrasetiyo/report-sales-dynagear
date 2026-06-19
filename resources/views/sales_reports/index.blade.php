@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">
            Report Sales
        </h3>

        @if(Auth::user()->role !== 'sales')
            <a href="{{ route('sales-reports.create') }}"
               class="btn btn-primary">
                + Tambah Report
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET"
          class="card card-body shadow-sm border-0 mb-3">

        <div class="row g-2 align-items-end">

            <div class="col-12 col-md-3">
                <label class="form-label small text-muted">
                    Pencarian
                </label>

                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Cari customer / SQ / PO"
                       value="{{ request('search') }}">
            </div>

            <div class="col-12 col-md-2">
                <label class="form-label small text-muted">
                    Status
                </label>

                <select name="status" class="form-select">
                    <option value="">Semua Status</option>

                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>

                    <option value="deal" {{ request('status') == 'deal' ? 'selected' : '' }}>
                        Deal
                    </option>

                    <option value="no_deal" {{ request('status') == 'no_deal' ? 'selected' : '' }}>
                        No Deal
                    </option>
                </select>
            </div>

            <div class="col-12 col-md-2">
                <label class="form-label small text-muted">
                    Bulan
                </label>

                <select name="month" class="form-select">
                    <option value="">Semua Bulan</option>

                    @foreach(range(1,12) as $m)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-2">
                <label class="form-label small text-muted">
                    Tahun
                </label>

                <select name="year" class="form-select">
                    <option value="">Semua Tahun</option>

                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            @if(Auth::user()->role !== 'sales')
                <div class="col-12 col-md-3">
                    <label class="form-label small text-muted">
                        Sales
                    </label>

                    <select name="sales_id" class="form-select">
                        <option value="">Semua Sales</option>

                        @foreach($salesUsers as $sales)
                            <option value="{{ $sales->id }}" {{ request('sales_id') == $sales->id ? 'selected' : '' }}>
                                {{ $sales->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="col-12 col-md-2">
                <button type="submit"
                        class="btn btn-dark w-100">
                    Filter
                </button>
            </div>

            <div class="col-12 col-md-2">
                <a href="{{ route('sales-reports.index') }}"
                   class="btn btn-secondary w-100">
                    Reset
                </a>
            </div>

            <div class="col-12 col-md-2">
                <a href="{{ route('sales-reports.print-index', request()->query()) }}"
                   target="_blank"
                   class="btn btn-danger w-100">
                    Cetak PDF
                </a>
            </div>

        </div>

    </form>

    <div class="row mb-3">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Pendapatan Deal</p>
                    <h4 class="fw-bold text-success">
                        Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
                    </h4>
                    <span class="badge bg-success">Status Deal</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Pending</p>
                    <h4 class="fw-bold text-warning">
                        Rp {{ number_format($totalPending ?? 0, 0, ',', '.') }}
                    </h4>
                    <span class="badge bg-warning text-dark">Status Pending</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Total No Deal</p>
                    <h4 class="fw-bold text-danger">
                        Rp {{ number_format($totalNoDeal ?? 0, 0, ',', '.') }}
                    </h4>
                    <span class="badge bg-danger">Status No Deal</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Semua Report</p>
                    <h4 class="fw-bold text-primary">
                        Rp {{ number_format($totalSemua ?? 0, 0, ',', '.') }}
                    </h4>
                    <span class="badge bg-primary">Berdasarkan Filter</span>
                </div>
            </div>
        </div>

    </div>

    <div class="card shadow border-0">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Sales</th>
                        <th>No SQ</th>
                        <th>No PO</th>
                        <th>Customer</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Price/Unit</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td>
                                {{ $loop->iteration + ($reports->currentPage() - 1) * $reports->perPage() }}
                            </td>

                            <td>{{ $report->tanggal }}</td>

                            <td>{{ $report->sales->name ?? '-' }}</td>

                            <td>{{ $report->no_sq }}</td>

                            <td>{{ $report->no_po }}</td>

                            <td>{{ $report->customer_name }}</td>

                            <td>{{ Str::limit($report->description, 40) }}</td>

                            <td>{{ $report->qty }}</td>

                            <td>
                                Rp {{ number_format($report->price_unit, 0, ',', '.') }}
                            </td>

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
                                   class="btn btn-info btn-sm">
                                    Detail
                                </a>

                                @if(Auth::user()->role !== 'sales')
    <a href="{{ route('sales-reports.edit', $report->id) }}"
       class="btn btn-warning btn-sm">
        Edit
    </a>
@endif

                                @if(Auth::user()->role !== 'sales') 
                                    <form action="{{ route('sales-reports.destroy', $report->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted">
                                Data report belum ada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $reports->links() }}

        </div>
    </div>

</div>
@endsection