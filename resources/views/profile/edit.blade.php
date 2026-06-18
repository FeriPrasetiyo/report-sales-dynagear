@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        👤 Profile Saya
                    </h4>
                </div>

                <div class="card-body">

                    @if(session('status') === 'profile-updated')
                        <div class="alert alert-success">
                            Profile berhasil diperbarui.
                        </div>
                    @endif

                    @if($errors->updateProfileInformation->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->updateProfileInformation->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="{{ old('name', $user->name) }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="{{ old('email', $user->email) }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <input type="text"
                                   class="form-control bg-light"
                                   value="{{ strtoupper($user->role) }}"
                                   readonly>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Simpan Perubahan
                        </button>
                    </form>

                </div>

            </div>

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-warning">
                    <h5 class="mb-0">
                        🔒 Ubah Password
                    </h5>
                </div>

                <div class="card-body">

                    @if(session('status') === 'password-updated')
                        <div class="alert alert-success">
                            Password berhasil diperbarui.
                        </div>
                    @endif

                    @if($errors->updatePassword->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->updatePassword->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Password Saat Ini</label>
                            <input type="password"
                                   name="current_password"
                                   class="form-control"
                                   required>

                            @error('current_password', 'updatePassword')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   minlength="8"
                                   required>

                            <small class="text-muted">
                                Password minimal 8 karakter.
                            </small>

                            @error('password', 'updatePassword')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control"
                                   minlength="8"
                                   required>

                            @error('password_confirmation', 'updatePassword')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-warning">
                            Update Password
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection