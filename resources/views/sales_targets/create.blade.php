@extends('layouts.app')

@section('content')

<div class="card border-0 shadow-sm">

    <div class="card-header">
        Tambah Target Sales
    </div>

    <div class="card-body">

        <form action="{{ route('sales-targets.store') }}"
              method="POST">

            @csrf

            <div class="mb-3">

                <label>Sales</label>

                <select name="sales_id"
                        class="form-select">

                    @foreach($salesUsers as $sales)

                    <option value="{{ $sales->id }}">
                        {{ $sales->name }}
                    </option>

                    @endforeach

                </select>

            </div>

            <div class="mb-3">

                <label>Bulan</label>

                <select name="month"
                        class="form-select">

                    @foreach(range(1,12) as $m)

                    <option value="{{ $m }}">
                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>

                    @endforeach

                </select>

            </div>

            <div class="mb-3">

                <label>Tahun</label>

                <input type="number"
                       name="year"
                       value="{{ date('Y') }}"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label>Target Sales</label>

                <input type="number"
                       name="target_amount"
                       class="form-control">

            </div>

            <button class="btn btn-primary">
                Simpan
            </button>

        </form>

    </div>

</div>

@endsection