@extends("layouts.admin")
@section("title", "Tambah Anggota")
@section("content")
<form method="POST" action="{{ route("admin.members.store") }}" class="card" style="max-width:640px;">
    @csrf
    <div class="form-group"><label>Nama</label><input type="text" name="name" class="form-control" value="{{ old("name") }}" required></div>
    <div class="form-group"><label>Kelas</label><input type="text" name="class" class="form-control" value="{{ old("class") }}" required></div>
    <div class="form-group"><label>No. HP</label><input type="text" name="phone" class="form-control" value="{{ old("phone") }}"></div>
    <div class="form-group"><label>Alamat</label><input type="text" name="address" class="form-control" value="{{ old("address") }}"></div>
    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
        </select>
    </div>
    <p style="font-size:12px; color:var(--ink-soft); margin-bottom:8px;">Opsional: buat akun login untuk anggota ini.</p>
    <div class="form-group"><label>Email (opsional)</label><input type="email" name="email" class="form-control" value="{{ old("email") }}"></div>
    <div class="form-group"><label>Password (opsional)</label><input type="password" name="password" class="form-control"></div>
    <button class="btn btn-solid">Simpan Anggota</button>
</form>
@endsection
