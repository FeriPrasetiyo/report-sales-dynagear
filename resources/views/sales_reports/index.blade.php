@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Report Sales</h3>

        <a href="{{ route('sales-reports.create') }}" class="btn btn-primary">
            + Tambah Report
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="card card-body shadow-sm border-0 mb-3">
        <div class="row">

            <div class="col-md-3 mb-2">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Cari customer / SQ / PO"
                       value="{{ request('search') }}">
            </div>

            <div class="col-md-2 mb-2">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="deal" {{ request('status') == 'deal' ? 'selected' : '' }}>Deal</option>
                    <option value="no_deal" {{ request('status') == 'no_deal' ? 'selected' : '' }}>No Deal</option>
                </select>
            </div>

            @if(Auth::user()->role !== 'sales')
                <div class="col-md-3 mb-2">
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

            <div class="col-md-2 mb-2">
                <button class="btn btn-dark w-100">
                    Filter
                </button>
            </div>

            <div class="col-md-2 mb-2">
                <a href="{{ route('sales-reports.index') }}" class="btn btn-secondary w-100">
                    Reset
                </a>
            </div>

        </div>
    </form>

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
                            <td>{{ $loop->iteration + ($reports->currentPage() - 1) * $reports->perPage() }}</td>
                            <td>{{ $report->tanggal }}</td>
                            <td>{{ $report->sales->name ?? '-' }}</td>
                            <td>{{ $report->no_sq }}</td>
                            <td>{{ $report->no_po }}</td>
                            <td>{{ $report->customer_name }}</td>
                            <td>{{ Str::limit($report->description, 40) }}</td>
                            <td>{{ $report->qty }}</td>
                            <td>Rp {{ number_format($report->price_unit, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($report->total, 0, ',', '.') }}</td>
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
                                <a href="{{ route('sales-reports.show', $report->id) }}" class="btn btn-info btn-sm">
                                    Detail
                                </a>

                                <a href="{{ route('sales-reports.edit', $report->id) }}" class="btn btn-warning btn-sm">
    {{ Auth::user()->role === 'sales' ? 'Ubah Status' : 'Edit' }}
</a>
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