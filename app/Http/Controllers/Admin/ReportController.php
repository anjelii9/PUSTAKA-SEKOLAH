<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TransactionsExport;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $transactions = $this->filtered($request)->latest()->paginate(15)->withQueryString();
        return view("admin.reports.index", compact("transactions"));
    }

    public function exportPdf(Request $request)
    {
        $transactions = $this->filtered($request)->latest()->get();
        $pdf = Pdf::loadView("admin.reports.pdf", compact("transactions"))->setPaper("a4", "landscape");
        return $pdf->download("laporan-transaksi-" . now()->format("Ymd-His") . ".pdf");
    }

    public function exportExcel(Request $request)
    {
        $transactions = $this->filtered($request)->latest()->get();
        return Excel::download(new TransactionsExport($transactions), "laporan-transaksi-" . now()->format("Ymd-His") . ".xlsx");
    }

    private function filtered(Request $request)
    {
        return Transaction::with(["book", "member"])
            ->when($request->status, fn ($q) => $q->where("status", $request->status))
            ->when($request->from, fn ($q) => $q->whereDate("borrow_date", ">=", $request->from))
            ->when($request->to, fn ($q) => $q->whereDate("borrow_date", "<=", $request->to));
    }
}
