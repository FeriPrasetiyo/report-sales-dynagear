@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="card shadow border-0">

        <div class="card-header">
            Edit User
        </div>

        <div class="card-body">

            <form action="{{ route('users.update',$user->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Nama</label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ $user->name }}">
                </div>

                <div class="mb-3">
                    <label>Email</label>

                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ $user->email }}">
                </div>

                <div class="mb-3">
                    <label>Password Baru</label>

                    <input type="password"
                           name="password"
                           class="form-control">

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengubah password
                    </small>
                </div>

                <div class="mb-3">
                    <label>Role</label>

                    <select name="role"
                            class="form-select">

                        <option value="admin"
                            {{ $user->role == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                        <option value="manager"
                            {{ $user->role == 'manager' ? 'selected' : '' }}>
                            Manager
                        </option>

                        <option value="sales"
                            {{ $user->role == 'sales' ? 'selected' : '' }}>
                            Sales
                        </option>

                    </select>
                </div>

                <button class="btn btn-success">
                    Update
                </button>

            </form>

        </div>

    </div>

</div>

@endsection