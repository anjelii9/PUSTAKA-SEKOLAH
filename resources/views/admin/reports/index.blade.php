@extends('layouts.admin')

@section('title', 'Laporan Transaksi')

@section('content')

    <form method="GET" style="display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap;">
        <select name="status" class="form-control" style="width:160px;">
            <option value="">Semua Status</option>
            <option value="dipinjam" @selected(request('status') == 'dipinjam')>Dipinjam</option>
            <option value="dikembalikan" @selected(request('status') == 'dikembalikan')>Dikembalikan</option>
            <option value="terlambat" @selected(request('status') == 'terlambat')>Terlambat</option>
        </select>

        <input
            type="date"
            name="from"
            class="form-control"
            style="width:160px;"
            value="{{ request('from') }}"
        >

        <input
            type="date"
            name="to"
            class="form-control"
            style="width:160px;"
            value="{{ request('to') }}"
        >

        <button type="submit" class="btn">Filter</button>

        <a href="{{ route('admin.reports.export-pdf', request()->query()) }}" class="btn btn-solid">
            Cetak PDF
        </a>

        <a href="{{ route('admin.reports.export-excel', request()->query()) }}" class="btn btn-solid">
            Export Excel
        </a>
    </form>

    <div class="card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Buku</th>
                    <th>Anggota</th>
                    <th>Pinjam</th>
                    <th>Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>

            <tbody>
                @forelse($transactions as $t)
                    <tr>
                        <td>{{ $t->transaction_code }}</td>
                        <td>{{ $t->book->title ?? '-' }}</td>
                        <td>{{ $t->member->name ?? '-' }}</td>

                        <td>
                            {{ $t->borrow_date ? \Carbon\Carbon::parse($t->borrow_date)->format('d-m-Y') : '-' }}
                        </td>

                        <td>
                            {{ $t->return_date ? \Carbon\Carbon::parse($t->return_date)->format('d-m-Y') : '-' }}
                        </td>

                        <td>
                            <span class="badge
                                {{ $t->status === 'dikembalikan' ? 'badge-available' : ($t->status === 'terlambat' ? 'badge-unavailable' : 'badge-late') }}">
                                {{ ucfirst($t->status) }}
                            </span>
                        </td>

                        <td>Rp {{ number_format($t->fine ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Tidak ada data pada rentang ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:16px;">
            {{ $transactions->withQueryString()->links() }}
        </div>
    </div>

@endsection
