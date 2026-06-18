@extends('layouts.app')

@section('content')

<div class="mb-3">
    <a href="{{ route('sales-targets.index') }}" class="btn btn-secondary">
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

<div class="card border-0 shadow-sm">

    <div class="card-header">
        Edit Target Sales
    </div>

    <div class="card-body">

        <form action="{{ route('sales-targets.update',$salesTarget->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label>Sales</label>

                <select name="sales_id"
                        class="form-select">

                    @foreach($salesUsers as $sales)

                    <option value="{{ $sales->id }}" {{ $salesTarget->sales_id == $sales->id ? 'selected' : '' }}>
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

                    <option value="{{ $m }}" {{ $salesTarget->month == $m ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>

                    @endforeach

                </select>

            </div>

            <div class="mb-3">

                <label>Tahun</label>

                <input type="number"
                       name="year"
                       value="{{ $salesTarget->year }}"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label>Target Sales</label>

                <input type="number"
                       name="target_amount"
                       value="{{ $salesTarget->target_amount }}"
                       class="form-control">

            </div>

            <button class="btn btn-primary">
                Simpan
            </button>

        </form>

    </div>

</div>

@endsection