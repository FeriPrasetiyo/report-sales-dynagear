@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h3 class="fw-bold">
        Target Sales Bulanan
    </h3>

    <a href="{{ route('sales-targets.create') }}"
       class="btn btn-primary">
        + Tambah Target
    </a>

</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card border-0 shadow-sm">

    <div class="card-body table-responsive">

        <table class="table table-bordered align-middle">

            <thead class="table-dark">
                <tr>
                    <th>Sales</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Target</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($targets as $target)

                <tr>

                    <td>{{ $target->sales->name }}</td>

                    <td>{{ $target->month }}</td>

                    <td>{{ $target->year }}</td>

                    <td>
                        Rp {{ number_format($target->target_amount,0,',','.') }}
                    </td>

                    <td>

                        <a href="{{ route('sales-targets.edit',$target->id) }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('sales-targets.destroy',$target->id) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus target?')">
                                Hapus
                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5" class="text-center">
                        Belum ada target sales
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

        {{ $targets->links() }}

    </div>

</div>

@endsection