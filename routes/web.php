<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Student\BookingController;
use App\Http\Controllers\Student\CatalogController;
use App\Http\Controllers\Student\HistoryController;
use App\Http\Controllers\Student\MemberCardController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::get("/", [HomeController::class, "index"])->name("home");

Route::middleware("guest")->group(function () {
    Route::get("/login", [LoginController::class, "showLoginForm"])->name("login");
    Route::post("/login", [LoginController::class, "login"]);
    Route::get("/register", [RegisterController::class, "showRegistrationForm"])->name("register");
    Route::post("/register", [RegisterController::class, "register"]);
});
Route::post("/logout", [LoginController::class, "logout"])->middleware("auth")->name("logout");

Route::middleware(["auth", "role:admin"])->prefix("admin")->name("admin.")->group(function () {
    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");

    Route::resource("books", BookController::class);

    // Cetak kartu anggota (harus di atas resource members)
    Route::get("members/{member}/card", [MemberController::class, "card"])->name("members.card");
    Route::resource("members", MemberController::class);

    Route::get("/transactions", [TransactionController::class, "index"])->name("transactions.index");
    Route::get("/transactions/create", [TransactionController::class, "create"])->name("transactions.create");
    Route::post("/transactions", [TransactionController::class, "store"])->name("transactions.store");
    Route::get("/transactions/{transaction}", [TransactionController::class, "show"])->name("transactions.show");
    Route::get("/transactions/{transaction}/return", [TransactionController::class, "returnForm"])->name("transactions.return-form");
    Route::post("/transactions/{transaction}/return", [TransactionController::class, "processReturn"])->name("transactions.return");
    Route::patch("/transactions/{transaction}/status", [TransactionController::class, "updateStatus"])->name("transactions.update-status");

    Route::get("/reports", [ReportController::class, "index"])->name("reports.index");
    Route::get("/reports/export/pdf", [ReportController::class, "exportPdf"])->name("reports.export-pdf");
    Route::get("/reports/export/excel", [ReportController::class, "exportExcel"])->name("reports.export-excel");

    // BOOKING (admin)
    Route::get("/bookings", [AdminBookingController::class, "index"])->name("bookings.index");
    Route::post("/bookings/{booking}/confirm", [AdminBookingController::class, "confirm"])->name("bookings.confirm");
});

Route::middleware(["auth", "role:siswa"])->prefix("student")->name("student.")->group(function () {
    Route::get("/catalog", [CatalogController::class, "index"])->name("catalog");
    Route::get("/catalog/{book}", [CatalogController::class, "show"])->name("catalog.show");
    Route::get("/history", [HistoryController::class, "index"])->name("history");
    Route::get("/profile", [ProfileController::class, "edit"])->name("profile");
    Route::put("/profile", [ProfileController::class, "update"])->name("profile.update");

    // KARTU ANGGOTA (siswa)
    Route::get("/card", [MemberCardController::class, "show"])->name("card");
    Route::put("/card", [MemberCardController::class, "update"])->name("card.update");
    Route::get("/card/print", [MemberCardController::class, "print"])->name("card.print");

    Route::post("/testimonials", [TestimonialController::class, "store"])->name("testimonials.store");
    Route::delete("/testimonials", [TestimonialController::class, "destroy"])->name("testimonials.destroy");

    // BOOKING (siswa)
    Route::get("/booking/{book}/create", [BookingController::class, "create"])->name("booking.create");
    Route::post("/booking/{book}", [BookingController::class, "store"])->name("booking.store");
});