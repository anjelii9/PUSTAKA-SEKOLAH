@extends("layouts.admin")
@section("title", "Ubah Anggota")
@section("content")
<form method="POST" action="{{ route("admin.members.update", $member) }}" class="card" style="max-width:640px;">
    @csrf @method("PUT")
    <div class="form-group"><label>Nama</label><input type="text" name="name" class="form-control" value="{{ old("name", $member->name) }}" required></div>
    <div class="form-group"><label>Kelas</label><input type="text" name="class" class="form-control" value="{{ old("class", $member->class) }}" required></div>
    <div class="form-group"><label>No. HP</label><input type="text" name="phone" class="form-control" value="{{ old("phone", $member->phone) }}"></div>
    <div class="form-group"><label>Alamat</label><input type="text" name="address" class="form-control" value="{{ old("address", $member->address) }}"></div>
    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="aktif" @selected($member->status=="aktif")>Aktif</option>
            <option value="nonaktif" @selected($member->status=="nonaktif")>Nonaktif</option>
        </select>
    </div>
    <button class="btn btn-solid">Simpan Perubahan</button>
</form>
@endsection
