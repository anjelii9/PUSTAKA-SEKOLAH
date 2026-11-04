
@extends('layouts.admin')

@section('title', 'Proses Pengembalian')

@section('content')

    <div class="card" style="max-width:560px;">

        <h3 style="margin-top:0; margin-bottom:20px;">
            Konfirmasi Pengembalian Buku
        </h3>

        <p>
            <strong>Kode Transaksi:</strong>
            {{ $transaction->transaction_code }}
        </p>

        <p>
            <strong>Buku:</strong>
            {{ $transaction->book->title ?? '-' }}
        </p>

        <p>
            <strong>Anggota:</strong>
            {{ $transaction->member->name ?? '-' }}
        </p>

        <p>
            <strong>Jatuh Tempo:</strong>
            {{ $transaction->due_date ? \Carbon\Carbon::parse($transaction->due_date)->format('d-m-Y') : '-' }}
        </p>

        <p>
            <strong>Hari Ini:</strong>
            {{ now()->format('d-m-Y') }}
        </p>

        @if($transaction->status === 'dikembalikan')
            <p style="color:var(--available); font-weight:700;">
                Buku ini sudah dikembalikan.
            </p>
        @elseif($estimasiDenda > 0)
            <p style="color:var(--unavailable); font-weight:700;">
                Terlambat! Estimasi denda:
                Rp {{ number_format($estimasiDenda, 0, ',', '.') }}
            </p>
        @else
            <p style="color:var(--available); font-weight:700;">
                Pengembalian tepat waktu, tidak ada denda.
            </p>
        @endif

        @if($transaction->status !== 'dikembalikan')
            <form
                method="POST"
                action="{{ route('admin.transactions.return', $transaction) }}"
                style="margin-top:20px; display:flex; gap:8px; flex-wrap:wrap;"
                onsubmit="return confirm('Yakin ingin mengonfirmasi pengembalian buku ini?')"
            >
                @csrf

                <button type="submit" class="btn btn-solid">
                    Konfirmasi Pengembalian
                </button>

                <a href="{{ route('admin.transactions.index') }}" class="btn">
                    Batal
                </a>
            </form>
        @else
            <a href="{{ route('admin.transactions.index') }}" class="btn">
                Kembali ke Transaksi
            </a>
        @endif

    </div>

@endsection
