@extends("layouts.app")
@section("title", $book->title)
@section("content")
<div class="container" style="padding: 48px 24px; display:flex; gap:40px; flex-wrap:wrap;">
    <div class="book-cover" style="width:280px; flex-shrink:0;">
        @if($book->cover)
            <img src="{{ asset("storage/".$book->cover) }}" alt="{{ $book->title }}">
        @else
            <span style="padding:20px; text-align:center; font-family:"Archivo Expanded";">{{ $book->title }}</span>
        @endif
    </div>
    <div style="flex:1; min-width:280px;">
        <span class="badge {{ $book->isAvailable() ? "badge-available" : "badge-unavailable" }}">
            {{ $book->isAvailable() ? "Tersedia" : "Dipinjam Semua" }}
        </span>
        <h1 style="font-size:34px; margin-top:12px;">{{ $book->title }}</h1>
        <p style="color:var(--ink-soft); margin-top:6px;">{{ $book->author }} &middot; {{ $book->publisher }} &middot; {{ $book->year }}</p>
        <p style="margin-top:6px; font-size:13px; text-transform:uppercase; letter-spacing:.04em;">Kategori: {{ $book->category->name ?? "-" }}</p>
        <p style="margin-top:6px; font-size:13px;">Nomor Buku: {{ $book->book_code }} &middot; Stok: {{ $book->stock }}</p>
        <p style="margin-top:20px; line-height:1.6;">{{ $book->description }}</p>
        <p style="margin-top:20px; font-size:13px; color:var(--ink-soft);">Untuk meminjam buku ini, silakan datang ke perpustakaan dan sampaikan nomor buku kepada petugas.</p>
    </div>
</div>
@endsection
