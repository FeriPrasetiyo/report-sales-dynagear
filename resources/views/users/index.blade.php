@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h3 class="fw-bold">
            Pengaturan User
        </h3>

        <a href="{{ route('users.create') }}"
           class="btn btn-primary">
            + Tambah User
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow border-0">

        <div class="card-body table-responsive">

            <table class="table table-bordered">

                <thead class="table-dark">

                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th width="180">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($users as $user)

                    <tr>

                        <td>{{ $user->id }}</td>

                        <td>{{ $user->name }}</td>

                        <td>{{ $user->email }}</td>

                        <td>

                            @if($user->role == 'admin')
                                <span class="badge bg-danger">Admin</span>
                            @elseif($user->role == 'manager')
                                <span class="badge bg-warning text-dark">Manager</span>
                            @else
                                <span class="badge bg-primary">Sales</span>
                            @endif

                        </td>

                        <td>

                            <a href="{{ route('users.edit',$user->id) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('users.destroy',$user->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus user?')">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm">
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="5" class="text-center">
                            Belum ada user
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

            {{ $users->links() }}

        </div>

    </div>

</div>

@endsection