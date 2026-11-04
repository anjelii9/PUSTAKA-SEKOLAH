@extends("layouts.app")
@section("title", "Katalog Buku")
@section("content")
<div class="container" style="padding: 48px 24px;">
    <h2 style="font-size:32px; margin-bottom:20px;">Katalog Buku</h2>

    <form method="GET" style="display:flex; gap:8px; margin-bottom:12px; flex-wrap:wrap;">
        <input type="text" name="q" class="form-control" style="flex:1; min-width:200px;" placeholder="Cari judul, penulis, atau kategori" value="{{ request('q') }}">
        <select name="category_id" class="form-control" style="width:200px;">
            <option value="">Semua Jenis Buku</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(request('category_id')==$c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
        <button class="btn btn-solid">Cari</button>
        @if(request('q') || request('category_id'))
            <a href="{{ route('student.catalog') }}" class="btn">Reset</a>
        @endif
    </form>
    <p style="font-size:12px; color:var(--ink-soft); margin-bottom:28px;">Gunakan kotak pencarian untuk judul/penulis, atau pilih dropdown untuk mencari berdasarkan jenis buku (kategori).</p>

    <div class="book-grid reveal-stagger">
        @forelse($books as $book)
            <div class="book-card">
                <a href="{{ route('student.catalog.show', $book) }}" style="text-decoration:none; color:inherit; display:block;">
                    <div class="book-cover">
                        @if($book->cover_url)
                         <img src="{{ $book->cover_url }}" alt="{{ $book->title }}">
                        @else
                            <span style="font-family:'Archivo Expanded'; font-size:13px; color:var(--ink-soft); text-align:center; padding:12px;">{{ $book->title }}</span>
                        @endif
                    </div>
                    <span class="badge {{ $book->isAvailable() ? 'badge-available' : 'badge-unavailable' }}">
                        {{ $book->isAvailable() ? 'Tersedia ('.$book->stock.' unit)' : 'Dipinjam Semua' }}
                    </span>
                    <div class="book-title">{{ $book->title }}</div>
                    <div class="book-meta">{{ $book->category->name ?? '-' }} &middot; {{ $book->author }}</div>
                </a>

                @if($book->isAvailable())
                    <a href="{{ route('student.booking.create', $book) }}" class="btn btn-solid" style="display:block; text-align:center; margin-top:8px; font-size:11px; padding:8px 12px;">Booking</a>
                @else
                    <span class="btn" style="display:block; text-align:center; margin-top:8px; font-size:11px; padding:8px 12px; opacity:.5; cursor:not-allowed;">Stok Habis</span>
                @endif
            </div>
        @empty
            <p>Buku tidak ditemukan untuk pencarian ini.</p>
        @endforelse
    </div>
    <div style="margin-top:24px;">{{ $books->links() }}</div>
</div>
@endsection