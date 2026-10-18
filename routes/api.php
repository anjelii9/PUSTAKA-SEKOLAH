<?php

use App\Http\Controllers\Api\Admin\BookController as AdminBookController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\MemberController;
use App\Http\Controllers\Api\Admin\TransactionController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);
Route::get("/categories", [CatalogController::class, "categories"]);
Route::get("/books", [CatalogController::class, "books"]);
Route::get("/books/{book}", [CatalogController::class, "show"]);
Route::get("/testimonials", [TestimonialController::class, "index"]);

Route::middleware("auth:sanctum")->group(function () {
    Route::post("/logout", [AuthController::class, "logout"]);
    Route::get("/me", [AuthController::class, "me"]);

    Route::middleware("role:siswa")->group(function () {
        Route::put("/profile", [ProfileController::class, "update"]);
        Route::get("/history", [HistoryController::class, "index"]);
        Route::post("/testimonials", [TestimonialController::class, "store"]);
        Route::delete("/testimonials", [TestimonialController::class, "destroy"]);
    });

    Route::middleware("role:admin")->prefix("admin")->group(function () {
        Route::get("/dashboard", [DashboardController::class, "index"]);
        Route::apiResource("books", AdminBookController::class);
        Route::apiResource("members", MemberController::class);
        Route::get("/transactions", [TransactionController::class, "index"]);
        Route::post("/transactions", [TransactionController::class, "store"]);
        Route::post("/transactions/{transaction}/return", [TransactionController::class, "processReturn"]);
    });
});
