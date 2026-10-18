@extends("layouts.admin")
@section("title", "Data Buku")
@section("content")
    <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
        <form method="GET" style="display:flex; gap:8px;">
            <input type="text" name="q" class="form-control" placeholder="Cari judul/penulis/nomor buku" value="{{ request("q") }}">
            <select name="category_id" class="form-control">
                <option value="">Semua Kategori</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(request("category_id")==$c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
            <button class="btn">Cari</button>
        </form>
        <a href="{{ route("admin.books.create") }}" class="btn btn-solid">+ Tambah Buku</a>
    </div>

    <div class="card">
        <table class="data-table">
            <thead><tr><th>Nomor Buku</th><th>Judul</th><th>Kategori</th><th>Stok</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($books as $book)
                <tr>
                    <td>{{ $book->book_code }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->category->name ?? "-" }}</td>
                    <td>
                        <span class="badge {{ $book->isAvailable() ? "badge-available" : "badge-unavailable" }}">{{ $book->stock }} unit</span>
                    </td>
                    <td style="display:flex; gap:8px;">
                        <a href="{{ route("admin.books.edit", $book) }}" class="btn" style="padding:6px 14px;">Ubah</a>
                        <form action="{{ route("admin.books.destroy", $book) }}" method="POST" onsubmit="return confirm("Hapus buku ini?")">
                            @csrf @method("DELETE")
                            <button class="btn" style="padding:6px 14px; border-color:var(--unavailable); color:var(--unavailable);">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Belum ada data buku.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div style="margin-top:16px;">{{ $books->links() }}</div>
    </div>
@endsection
