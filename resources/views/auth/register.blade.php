@extends("layouts.app")
@section("title", "Daftar Anggota — Perpustakaan Sekolah")
@section("content")
<div class="container" style="max-width:520px; padding:80px 24px;">
    <h2 style="font-size:32px; margin-bottom:8px;">Daftar Anggota</h2>
    <p style="color:var(--ink-soft); font-size:14px; margin-bottom:28px;">Registrasi sebagai siswa untuk mulai meminjam buku.</p>

    <form method="POST" action="{{ route("register") }}" class="card">
        @csrf
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ old("name") }}" required>
            @error("name") <div class="error-text">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old("email") }}" required>
            @error("email") <div class="error-text">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Kelas</label>
            <input type="text" name="class" class="form-control" value="{{ old("class") }}" placeholder="Contoh: XI IPA 2" required>
            @error("class") <div class="error-text">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>No. HP</label>
            <input type="text" name="phone" class="form-control" value="{{ old("phone") }}">
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="address" class="form-control" value="{{ old("address") }}">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
            @error("password") <div class="error-text">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-solid" style="width:100%;">Daftar</button>
    </form>
    <p style="margin-top:16px; font-size:14px;">Sudah punya akun? <a href="{{ route("login") }}" style="text-decoration:underline;">Masuk</a></p>
</div>
@endsection
