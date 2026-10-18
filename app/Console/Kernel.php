<?php

namespace App\Console;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            Transaction::where("status", "dipinjam")
                ->where("due_date", "<", Carbon::today())
                ->update(["status" => "terlambat"]);
        })->dailyAt("00:05");
    }

    protected function commands(): void
    {
        $this->load(__DIR__."/Commands");
        require base_path("routes/console.php");
    }
}
