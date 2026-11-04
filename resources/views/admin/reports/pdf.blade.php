
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Perpustakaan</title>

    <style>
        @page {
            margin: 24px;
        }

        body {
            font-family: sans-serif;
            font-size: 10px;
            color: #16140f;
        }

        h2 {
            margin: 0 0 6px;
            font-size: 17px;
            text-align: center;
        }

        p {
            margin: 0;
            text-align: center;
            color: #555;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 6px 5px;
            text-align: left;
        }

        th {
            background-color: #efe9dc;
            font-weight: bold;
        }

        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <h2>Laporan Transaksi Peminjaman &amp; Pengembalian Buku</h2>

    <p>
        Perpustakaan Sekolah |
        Dicetak pada {{ now()->format('d-m-Y H:i') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Buku</th>
                <th>Anggota</th>
                <th>Kelas</th>
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
                    <td>{{ $t->transaction_code }}</td>
                    <td>{{ $t->book->title ?? '-' }}</td>
                    <td>{{ $t->member->name ?? '-' }}</td>
                    <td>{{ $t->member->class ?? '-' }}</td>

                    <td>
                        {{ $t->borrow_date ? \Carbon\Carbon::parse($t->borrow_date)->format('d-m-Y') : '-' }}
                    </td>

                    <td>
                        {{ $t->due_date ? \Carbon\Carbon::parse($t->due_date)->format('d-m-Y') : '-' }}
                    </td>

                    <td>
                        {{ $t->return_date ? \Carbon\Carbon::parse($t->return_date)->format('d-m-Y') : '-' }}
                    </td>

                    <td>{{ ucfirst($t->status) }}</td>

                    <td class="text-right">
                        Rp {{ number_format($t->fine ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">
                        Tidak ada data transaksi.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
