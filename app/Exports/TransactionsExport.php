<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(protected Collection $transactions) {}

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return ["Kode Transaksi", "Judul Buku", "Nama Anggota", "Kelas", "Tgl Pinjam", "Jatuh Tempo", "Tgl Kembali", "Status", "Denda (Rp)"];
    }

    public function map($t): array
    {
        return [
            $t->transaction_code,
            $t->book->title ?? "-",
            $t->member->name ?? "-",
            $t->member->class ?? "-",
            optional($t->borrow_date)->format("d-m-Y"),
            optional($t->due_date)->format("d-m-Y"),
            $t->return_date ? $t->return_date->format("d-m-Y") : "-",
            ucfirst($t->status),
            number_format($t->fine, 0, ",", "."),
        ];
    }
}
