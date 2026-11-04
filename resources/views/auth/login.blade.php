
@extends('layouts.app')

@section('title', 'Login — Perpustakaan Sekolah')

@section('content')
<div class="container" style="max-width:440px; padding:80px 24px;">

    <h2 style="font-size:32px; margin-bottom:8px;">
        Masuk
    </h2>

    <p style="color:var(--ink-soft); font-size:14px; margin-bottom:28px;">
        Masuk untuk mengakses katalog &amp; riwayat peminjaman.
    </p>

    <form method="POST" action="{{ route('login') }}" class="card">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                required
                autofocus
            >
            @error('email')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-control"
                required
            >
            @error('password')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <label style="font-size:13px; display:flex; gap:8px; align-items:center; margin-bottom:18px;">
            <input type="checkbox" name="remember" value="1">
            Ingat saya
        </label>

        <button type="submit" class="btn btn-solid" style="width:100%;">
            Masuk
        </button>
    </form>

    <p style="margin-top:16px; font-size:14px;">
        Belum punya akun?
        <a href="{{ route('register') }}" style="text-decoration:underline;">
            Daftar sebagai siswa
        </a>
    </p>

    <p style="margin-top:8px; font-size:12px; color:var(--ink-soft);">
        Demo admin: admin@perpus.sekolah.id / password123
        <br>
        Demo siswa: siswa@perpus.sekolah.id / password123
    </p>

</div>
@endsection
