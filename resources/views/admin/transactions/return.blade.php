@extends("layouts.admin")
@section("title", "Proses Pengembalian")
@section("content")
<div class="card" style="max-width:560px;">
    <p><strong>Buku:</strong> {{ $transaction->book->title ?? "-" }}</p>
    <p><strong>Anggota:</strong> {{ $transaction->member->name ?? "-" }}</p>
    <p><strong>Jatuh Tempo:</strong> {{ $transaction->due_date->format("d-m-Y") }}</p>
    <p><strong>Hari ini:</strong> {{ now()->format("d-m-Y") }}</p>
    @if($estimasiDenda > 0)
        <p style="color:var(--unavailable); font-weight:700;">Terlambat! Estimasi denda: Rp {{ number_format($estimasiDenda,0,",",".") }}</p>
    @else
        <p style="color:var(--available); font-weight:700;">Pengembalian tepat waktu, tidak ada denda.</p>
    @endif
    <form method="POST" action="{{ route("admin.transactions.return", $transaction) }}" style="margin-top:16px;">
        @csrf
        <button class="btn btn-solid">Konfirmasi Pengembalian</button>
        <a href="{{ route("admin.transactions.index") }}" class="btn">Batal</a>
    </form>
</div>
@endsection
