<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("bookings", function (Blueprint $table) {
            $table->id();
            $table->string("booking_code")->unique();
            $table->foreignId("book_id")->constrained("books")->cascadeOnDelete();
            $table->foreignId("member_id")->constrained("members")->cascadeOnDelete();
            // Terisi otomatis saat admin konfirmasi pengambilan -> jadi transaksi peminjaman beneran
            $table->foreignId("transaction_id")->nullable()->constrained("transactions")->nullOnDelete();
            $table->date("booking_date");
            $table->time("pickup_time");
            $table->enum("status", ["menunggu", "dikonfirmasi", "dibatalkan"])->default("menunggu");
            $table->timestamp("confirmed_at")->nullable();
            $table->timestamp("cancelled_at")->nullable();
            // Dipakai buat notifikasi: true kalau siswa sudah lihat perubahan status terbarunya
            $table->boolean("is_read")->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("bookings");
    }
};