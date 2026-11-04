
@extends('layouts.admin')

@section('title', 'Detail Transaksi')

@section('content')

    <div class="card" style="max-width:640px;">

        <h3 style="margin-top:0; margin-bottom:20px;">
            Detail Transaksi Peminjaman
        </h3>

        <table class="data-table">
            <tbody>
                <tr>
                    <th>Kode Transaksi</th>
                    <td>{{ $transaction->transaction_code }}</td>
                </tr>

                <tr>
                    <th>Buku</th>
                    <td>
                        {{ $transaction->book->title ?? '-' }}
                        ({{ $transaction->book->book_code ?? '-' }})
                    </td>
                </tr>

                <tr>
                    <th>Anggota</th>
                    <td>
                        {{ $transaction->member->name ?? '-' }}
                        — {{ $transaction->member->class ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Petugas</th>
                    <td>{{ $transaction->admin->name ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Tanggal Pinjam</th>
                    <td>
                        {{ $transaction->borrow_date ? \Carbon\Carbon::parse($transaction->borrow_date)->format('d-m-Y') : '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Jatuh Tempo</th>
                    <td>
                        {{ $transaction->due_date ? \Carbon\Carbon::parse($transaction->due_date)->format('d-m-Y') : '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Tanggal Kembali</th>
                    <td>
                        {{ $transaction->return_date ? \Carbon\Carbon::parse($transaction->return_date)->format('d-m-Y') : '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge {{ $transaction->status === 'dikembalikan' ? 'badge-available' : ($transaction->status === 'terlambat' ? 'badge-unavailable' : 'badge-late') }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                </tr>

                <tr>
                    <th>Denda</th>
                    <td>
                        Rp {{ number_format($transaction->fine ?? 0, 0, ',', '.') }}
                    </td>
                </tr>

                <tr>
                    <th>Catatan</th>
                    <td>{{ $transaction->notes ?? '-' }}</td>
                </tr>
            </tbody>
        </table>

        <div style="display:flex; gap:8px; flex-wrap:wrap; margin-top:16px;">
            <a href="{{ route('admin.transactions.index') }}" class="btn">
                Kembali
            </a>

            @if($transaction->status !== 'dikembalikan')
                <a
                    href="{{ route('admin.transactions.return-form', $transaction) }}"
                    class="btn btn-solid"
                >
                    Proses Pengembalian
                </a>
            @endif
        </div>

    </div>

@endsection
