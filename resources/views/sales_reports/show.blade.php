@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Detail Report Sales</h3>

        <a href="{{ route('sales-reports.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">

        <div class="col-md-8 mb-3">
            <div class="card shadow border-0">
                <div class="card-header fw-bold">
                    Informasi Report
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Sales</th>
                            <td>{{ $salesReport->sales->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ $salesReport->tanggal }}</td>
                        </tr>
                        <tr>
                            <th>No SQ</th>
                            <td>{{ $salesReport->no_sq ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>No PO</th>
                            <td>{{ $salesReport->no_po ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Customer</th>
                            <td>{{ $salesReport->customer_name }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $salesReport->description }}</td>
                        </tr>
                        <tr>
                            <th>Qty</th>
                            <td>{{ $salesReport->qty }}</td>
                        </tr>
                        <tr>
                            <th>Price Unit</th>
                            <td>Rp {{ number_format($salesReport->price_unit, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>Rp {{ number_format($salesReport->total, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($salesReport->status == 'deal')
                                    <span class="badge bg-success">Deal</span>
                                @elseif($salesReport->status == 'no_deal')
                                    <span class="badge bg-danger">No Deal</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Follow Up</th>
                            <td>{{ $salesReport->next_followup_date ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Komentar Sales</th>
                            <td>{{ $salesReport->sales_comment ?? '-' }}</td>
                        </tr>
                    </table>

                   @if(Auth::user()->role !== 'sales')
    <a href="{{ route('sales-reports.edit', $salesReport->id) }}"
       class="btn btn-warning">
        Edit Report
    </a>
    <a href="{{ route('sales-reports.print', $salesReport->id) }}"
   target="_blank"
   class="btn btn-danger">
    Cetak PDF
</a>
@endif
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow border-0">
                <div class="card-header fw-bold">
                    Komentar
                </div>

                <div class="card-body" style="max-height: 400px; overflow-y: auto;">

                    @forelse($salesReport->comments as $comment)
                        <div class="mb-3 p-3 rounded bg-light border">
                            <div class="fw-bold">
                                {{ $comment->user->name ?? '-' }}
                                <span class="badge bg-secondary">
                                    {{ $comment->user->role ?? '-' }}
                                </span>
                            </div>

                            <small class="text-muted">
                                {{ $comment->created_at->format('d-m-Y H:i') }}
                            </small>

                            <div class="mt-2">
                                {{ $comment->comment }}
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">
                            Belum ada komentar.
                        </p>
                    @endforelse

                </div>

                <div class="card-footer">
                    <form action="{{ route('sales-reports.comments.store', $salesReport->id) }}" method="POST">
                        @csrf

                        <div class="mb-2">
                            <textarea name="comment"
                                      rows="3"
                                      class="form-control"
                                      placeholder="Tulis komentar..."
                                      required></textarea>
                        </div>

                        <button class="btn btn-primary w-100">
                            Kirim Komentar
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection