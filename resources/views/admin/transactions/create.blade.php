@extends("layouts.admin")
@section("title", "Input Peminjaman")
@section("content")
<form method="POST" action="{{ route("admin.transactions.store") }}" class="card" style="max-width:640px;">
    @csrf
    <div class="form-group">
        <label>Buku (Nomor Buku)</label>
        <select name="book_id" class="form-control" required>
            <option value="">Pilih buku</option>
            @foreach($books as $b)
                <option value="{{ $b->id }}">{{ $b->book_code }} — {{ $b->title }} (stok: {{ $b->stock }})</option>
            @endforeach
        </select>
        @error("book_id") <div class="error-text">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label>Anggota (Siswa)</label>
        <select name="member_id" class="form-control" required>
            <option value="">Pilih anggota</option>
            @foreach($members as $m)
                <option value="{{ $m->id }}">{{ $m->member_code }} — {{ $m->name }} ({{ $m->class }})</option>
            @endforeach
        </select>
        @error("member_id") <div class="error-text">{{ $message }}</div> @enderror
    </div>
    <p style="font-size:12px; color:var(--ink-soft);">Tanggal pinjam & jatuh tempo diatur otomatis oleh sistem (jatuh tempo: {{ config("perpustakaan.lama_pinjam_hari") }} hari dari sekarang).</p>
    <div class="form-group">
        <label>Catatan (opsional)</label>
        <input type="text" name="notes" class="form-control">
    </div>
    <button class="btn btn-solid">Simpan Peminjaman</button>
</form>
@endsection
