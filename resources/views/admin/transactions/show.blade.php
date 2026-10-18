@extends("layouts.admin")
@section("title", "Detail Transaksi")
@section("content")
<div class="card" style="max-width:640px;">
    <table class="data-table">
        <tr><th>Kode Transaksi</th><td>{{ $transaction->transaction_code }}</td></tr>
        <tr><th>Buku</th><td>{{ $transaction->book->title ?? "-" }} ({{ $transaction->book->book_code ?? "-" }})</td></tr>
        <tr><th>Anggota</th><td>{{ $transaction->member->name ?? "-" }} — {{ $transaction->member->class ?? "-" }}</td></tr>
        <tr><th>Petugas</th><td>{{ $transaction->admin->name ?? "-" }}</td></tr>
        <tr><th>Tgl Pinjam</th><td>{{ $transaction->borrow_date->format("d-m-Y") }}</td></tr>
        <tr><th>Jatuh Tempo</th><td>{{ $transaction->due_date->format("d-m-Y") }}</td></tr>
        <tr><th>Tgl Kembali</th><td>{{ $transaction->return_date ? $transaction->return_date->format("d-m-Y") : "-" }}</td></tr>
        <tr><th>Status</th><td>{{ ucfirst($transaction->status) }}</td></tr>
        <tr><th>Denda</th><td>Rp {{ number_format($transaction->fine,0,",",".") }}</td></tr>
        <tr><th>Catatan</th><td>{{ $transaction->notes ?? "-" }}</td></tr>
    </table>
    <a href="{{ route("admin.transactions.index") }}" class="btn" style="margin-top:16px;">Kembali</a>
</div>
@endsection
