@extends("layouts.admin")
@section("title", "Transaksi Peminjaman")
@section("content")
    <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
        <form method="GET" style="display:flex; gap:8px;">
            <input type="text" name="q" class="form-control" placeholder="Cari judul buku / anggota" value="{{ request("q") }}">
            <select name="status" class="form-control">
                <option value="">Semua Status</option>
                <option value="dipinjam" @selected(request("status")=="dipinjam")>Dipinjam</option>
                <option value="dikembalikan" @selected(request("status")=="dikembalikan")>Dikembalikan</option>
                <option value="terlambat" @selected(request("status")=="terlambat")>Terlambat</option>
            </select>
            <button class="btn">Filter</button>
        </form>
        <a href="{{ route("admin.transactions.create") }}" class="btn btn-solid">+ Input Peminjaman</a>
    </div>
    <div class="card">
        <table class="data-table">
            <thead><tr><th>Kode</th><th>Buku</th><th>Anggota</th><th>Pinjam</th><th>Jatuh Tempo</th><th>Status</th><th>Denda</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($transactions as $t)
                <tr>
                    <td>{{ $t->transaction_code }}</td>
                    <td>{{ $t->book->title ?? "-" }}</td>
                    <td>{{ $t->member->name ?? "-" }}</td>
                    <td>{{ $t->borrow_date->format("d-m-Y") }}</td>
                    <td>{{ $t->due_date->format("d-m-Y") }}</td>
                    <td><span class="badge {{ $t->status === "dikembalikan" ? "badge-available" : ($t->status === "terlambat" ? "badge-unavailable" : "badge-late") }}">{{ ucfirst($t->status) }}</span></td>
                    <td>Rp {{ number_format($t->fine,0,",",".") }}</td>
                    <td style="display:flex; gap:8px;">
                        <a href="{{ route("admin.transactions.show", $t) }}" class="btn" style="padding:6px 14px;">Detail</a>
                        @if($t->status !== "dikembalikan")
                            <a href="{{ route("admin.transactions.return-form", $t) }}" class="btn btn-solid" style="padding:6px 14px;">Kembalikan</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="8">Belum ada transaksi.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div style="margin-top:16px;">{{ $transactions->links() }}</div>
    </div>
@endsection
