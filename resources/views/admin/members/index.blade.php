@extends("layouts.admin")
@section("title", "Data Anggota")
@section("content")
    <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
        <form method="GET" style="display:flex; gap:8px;">
            <input type="text" name="q" class="form-control" placeholder="Cari nama / kode anggota" value="{{ request("q") }}">
            <button class="btn">Cari</button>
        </form>
        <a href="{{ route("admin.members.create") }}" class="btn btn-solid">+ Tambah Anggota</a>
    </div>
    <div class="card">
        <table class="data-table">
            <thead><tr><th>Kode</th><th>Nama</th><th>Kelas</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($members as $m)
                <tr>
                    <td>{{ $m->member_code }}</td>
                    <td>{{ $m->name }}</td>
                    <td>{{ $m->class }}</td>
                    <td><span class="badge {{ $m->status === "aktif" ? "badge-available" : "badge-unavailable" }}">{{ ucfirst($m->status) }}</span></td>
                    <td style="display:flex; gap:8px;">
                        <a href="{{ route("admin.members.edit", $m) }}" class="btn" style="padding:6px 14px;">Ubah</a>
                        <form action="{{ route("admin.members.destroy", $m) }}" method="POST" onsubmit="return confirm("Hapus anggota ini?")">
                            @csrf @method("DELETE")
                            <button class="btn" style="padding:6px 14px; border-color:var(--unavailable); color:var(--unavailable);">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Belum ada data anggota.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div style="margin-top:16px;">{{ $members->links() }}</div>
    </div>
@endsection
