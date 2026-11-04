@extends("layouts.app")
@section("title", "Booking Buku")
@section("content")
<div class="container" style="padding:48px 24px; max-width:640px;">
    <h2 style="font-size:32px; margin-bottom:8px;">Booking Buku</h2>
    <p style="color:var(--ink-soft); font-size:14px; margin-bottom:28px;">Pesan jam pengambilan untuk buku berikut, lalu ambil ke perpustakaan sesuai jadwal.</p>

    <div class="card" style="display:flex; gap:16px; align-items:center; margin-bottom:24px;">
        <div class="book-cover" style="width:70px; height:94px; flex-shrink:0;">
            @if($book->cover_url)
               <img src="{{ $book->cover_url }}" alt="{{ $book->title }}">
            @else
                <span style="font-size:9px; text-align:center; padding:4px; color:var(--ink-soft);">{{ $book->title }}</span>
            @endif
        </div>
        <div>
            <div style="font-weight:700;">{{ $book->title }}</div>
            <div class="book-meta">{{ $book->category->name ?? '-' }} &middot; {{ $book->author }}</div>
            <span class="badge badge-available" style="margin-top:6px;">Tersedia ({{ $book->stock }} unit)</span>
            <div style="margin-top:8px; font-size:13px;">📍 <strong>{{ $book->locationMessage() }}</strong></div>
        </div>
    </div>

    {{-- PERATURAN BOOKING --}}
    <div class="card" style="background:var(--bone); border-color:var(--accent); margin-bottom:24px;">
        <h3 style="font-size:15px; text-transform:none; letter-spacing:normal; margin-bottom:12px; color:var(--accent);">⚠ Peraturan Booking</h3>
        <ul style="margin:0; padding-left:18px; font-size:13px; line-height:1.8; color:var(--ink-soft);">
            <li>Booking hanya berlaku untuk <strong>hari ini</strong>, jam operasional pengambilan <strong>08.00 &ndash; 15.00 WIB</strong>.</li>
            <li>Kamu <strong>wajib mengambil buku sesuai jadwal</strong> yang dipilih di bawah.</li>
            <li>Jika terlambat <strong>lebih dari 10 menit</strong> dari jam pengambilan, booking akan <strong>dibatalkan otomatis</strong> oleh sistem dan stok buku dikembalikan.</li>
            <li>Satu buku hanya bisa di-booking satu kali dalam satu waktu (nggak bisa dobel booking buku yang sama).</li>
        </ul>
    </div>

    @if($errors->any())
        <div style="background:#f7eae8; border:1px solid var(--unavailable); color:var(--unavailable); padding:12px 16px; font-size:14px; margin-bottom:20px;">
            @foreach($errors->all() as $e)
                <div>{{ $e }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('student.booking.store', $book) }}" class="card">
        @csrf
        <div class="form-group">
            <label>Pilih Jam Pengambilan</label>
            <select name="pickup_time" class="form-control" required>
                <option value="">-- Pilih jam --</option>
                @foreach($slots as $slot)
                    <option value="{{ $slot }}" @selected(old('pickup_time')==$slot)>{{ $slot }} WIB</option>
                @endforeach
            </select>
        </div>

        <label style="display:flex; gap:10px; align-items:flex-start; font-size:13px; margin-bottom:20px; line-height:1.5;">
            <input type="checkbox" name="agree" value="1" style="margin-top:3px;" @checked(old('agree')) required>
            <span>Saya sudah membaca dan <strong>menyetujui peraturan booking</strong> di atas, termasuk konsekuensi pembatalan otomatis kalau terlambat lebih dari 10 menit.</span>
        </label>

        <button type="submit" class="btn btn-solid" style="width:100%;">Konfirmasi Booking</button>
        <a href="{{ route('student.catalog.show', $book) }}" class="btn" style="width:100%; margin-top:10px; text-align:center;">Batal</a>
    </form>
</div>
@endsection