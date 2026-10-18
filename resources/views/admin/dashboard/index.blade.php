@extends("layouts.admin")
@section("title", "Dashboard")
@section("content")
    <div style="display:grid; grid-template-columns:repeat(5,1fr); gap:16px; margin-bottom:32px;">
        <div class="stat-card"><div class="num" data-count-target="{{ $totalBuku }}">0</div><div class="label">Judul Buku</div></div>
        <div class="stat-card"><div class="num" data-count-target="{{ $totalStok }}">0</div><div class="label">Total Stok Buku</div></div>
        <div class="stat-card"><div class="num" data-count-target="{{ $transaksiAktif }}">0</div><div class="label">Peminjaman Aktif</div></div>
        <div class="stat-card"><div class="num" style="color:var(--unavailable);" data-count-target="{{ $terlambat }}">0</div><div class="label">Terlambat</div></div>
        <div class="stat-card"><div class="num" data-count-target="{{ $totalAnggota }}">0</div><div class="label">Anggota</div></div>
    </div>

    <div class="card reveal">
        <h3 style="font-size:16px; text-transform:none; letter-spacing:normal; margin-bottom:16px;">Transaksi Terbaru</h3>
        <table class="data-table">
            <thead><tr><th>Kode</th><th>Buku</th><th>Anggota</th><th>Jatuh Tempo</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($transaksiTerbaru as $t)
                <tr>
                    <td>{{ $t->transaction_code }}</td>
                    <td>{{ $t->book->title ?? "-" }}</td>
                    <td>{{ $t->member->name ?? "-" }}</td>
                    <td>{{ $t->due_date->format("d-m-Y") }}</td>
                    <td>
                        <span class="badge {{ $t->status === "dikembalikan" ? "badge-available" : ($t->status === "terlambat" ? "badge-unavailable" : "badge-late") }}">{{ ucfirst($t->status) }}</span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Belum ada transaksi.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
