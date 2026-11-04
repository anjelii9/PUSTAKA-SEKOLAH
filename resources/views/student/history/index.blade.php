@extends("layouts.app")
@section("title", "Riwayat Peminjaman")
@section("content")
<div class="container" style="padding:48px 24px;">
    <h2 style="font-size:32px; margin-bottom:20px;">Riwayat Peminjaman</h2>
    <div class="card">
        <table class="data-table table-stack">
            <thead>
                <tr>
                    <th>Buku</th>
                    <th>Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
            @forelse($transactions as $t)
                <tr>
                    <td data-label="Buku">{{ $t->book->title ?? "-" }}</td>
                    <td data-label="Pinjam">{{ $t->borrow_date->format("d-m-Y") }}</td>
                    <td data-label="Jatuh Tempo">{{ $t->due_date->format("d-m-Y") }}</td>
                    <td data-label="Kembali">{{ $t->return_date ? $t->return_date->format("d-m-Y") : "-" }}</td>
                    <td data-label="Status">
                        <span class="badge {{ $t->status === "dikembalikan" ? "badge-available" : ($t->status === "terlambat" ? "badge-unavailable" : "badge-late") }}">
                            {{ ucfirst($t->status) }}
                        </span>
                    </td>
                    <td data-label="Denda">Rp {{ number_format($t->fine, 0, ",", ".") }}</td>
                </tr>
            @empty
                <tr><td colspan="6">Anda belum memiliki riwayat peminjaman.</td></tr>
            @endforelse
            </tbody>
        </table>
        @if(method_exists($transactions, "links"))
            <div style="margin-top:16px;">{{ $transactions->links() }}</div>
        @endif
    </div>
</div>
@endsection