@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Tambah Report Sales</h3>

        <a href="{{ route('sales-reports.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sales-reports.store') }}" method="POST">

        @csrf

        <div class="card shadow border-0">

            <div class="card-body">

                <div class="row">

                    @if(Auth::user()->role != 'sales')
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Sales</label>

                        <select name="sales_id" class="form-select">
                            @foreach($salesUsers as $sales)
                                <option value="{{ $sales->id }}">
                                    {{ $sales->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal</label>

                        <input type="date"
                               name="tanggal"
                               class="form-control"
                               value="{{ old('tanggal') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>

                        <select name="status" class="form-select">

                            <option value="pending">
                                Pending
                            </option>

                            <option value="deal">
                                Deal
                            </option>

                            <option value="no_deal">
                                No Deal
                            </option>

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">No SQ</label>

                        <input type="text"
                               name="no_sq"
                               class="form-control"
                               value="{{ old('no_sq') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">No PO</label>

                        <input type="text"
                               name="no_po"
                               class="form-control"
                               value="{{ old('no_po') }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Customer Name</label>

                        <input type="text"
                               name="customer_name"
                               class="form-control"
                               value="{{ old('customer_name') }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>

                        <textarea name="description"
                                  rows="3"
                                  class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Qty</label>

                        <input type="number"
                               id="qty"
                               name="qty"
                               class="form-control"
                               value="1">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Price Unit</label>

                        <input type="number"
                               id="price_unit"
                               name="price_unit"
                               class="form-control"
                               value="0">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Total</label>

                        <input type="text"
                               id="total"
                               class="form-control bg-light"
                               readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Follow Up Berikutnya
                        </label>

                        <input type="date"
                               name="next_followup_date"
                               class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">
                            Komentar Sales
                        </label>

                        <textarea name="sales_comment"
                                  rows="4"
                                  class="form-control"></textarea>
                    </div>

                </div>

            </div>

            <div class="card-footer text-end">

                <button type="submit"
                        class="btn btn-primary">

                    Simpan Report

                </button>

            </div>

        </div>

    </form>

</div>

<script>

function hitungTotal()
{
    let qty = document.getElementById('qty').value || 0;
    let price = document.getElementById('price_unit').value || 0;

    document.getElementById('total').value =
        (qty * price).toLocaleString('id-ID');
}

document.getElementById('qty')
    .addEventListener('keyup', hitungTotal);

document.getElementById('price_unit')
    .addEventListener('keyup', hitungTotal);

document.getElementById('qty')
    .addEventListener('change', hitungTotal);

document.getElementById('price_unit')
    .addEventListener('change', hitungTotal);

hitungTotal();

</script>

@endsection