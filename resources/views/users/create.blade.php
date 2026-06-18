@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="card shadow border-0">

        <div class="card-header">
            Tambah User
        </div>

        <div class="card-body">

            <form action="{{ route('users.store') }}"
                  method="POST">

                @csrf

                <div class="mb-3">
                    <label>Nama</label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label>Email</label>

                    <input type="email"
                           name="email"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label>Password</label>

                    <input type="password"
                           name="password"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label>Role</label>

                    <select name="role"
                            class="form-select">

                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                        <option value="sales">Sales</option>

                    </select>
                </div>

                <button class="btn btn-primary">
                    Simpan
                </button>

            </form>

        </div>

    </div>

</div>

@endsection