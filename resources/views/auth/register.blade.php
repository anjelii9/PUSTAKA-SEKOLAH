
@extends('layouts.app')

@section('title', 'Daftar Anggota — Perpustakaan Sekolah')

@section('content')
<div class="container" style="max-width:520px; padding:80px 24px;">

    <h2 style="font-size:32px; margin-bottom:8px;">
        Daftar Anggota
    </h2>

    <p style="color:var(--ink-soft); font-size:14px; margin-bottom:28px;">
        Registrasi sebagai siswa untuk mulai meminjam buku.
    </p>

    <form method="POST" action="{{ route('register') }}" class="card">
        @csrf

        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                required
            >
            @error('name')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                required
            >
            @error('email')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="class">Kelas</label>
            <input
                type="text"
                id="class"
                name="class"
                class="form-control"
                value="{{ old('class') }}"
                placeholder="Contoh: XI RPL"
                required
            >
            @error('class')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="phone">No. HP</label>
            <input
                type="text"
                id="phone"
                name="phone"
                class="form-control"
                value="{{ old('phone') }}"
            >
            @error('phone')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">Alamat</label>
            <input
                type="text"
                id="address"
                name="address"
                class="form-control"
                value="{{ old('address') }}"
            >
            @error('address')
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

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control"
                required
            >
        </div>

        <button type="submit" class="btn btn-solid" style="width:100%;">
            Daftar
        </button>
    </form>

    <p style="margin-top:16px; font-size:14px;">
        Sudah punya akun?
        <a href="{{ route('login') }}" style="text-decoration:underline;">
            Masuk
        </a>
    </p>

</div>
@endsection
