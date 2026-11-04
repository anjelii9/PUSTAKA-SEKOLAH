<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table("books", function (Blueprint $table) {
            // Lokasi fisik buku: rak 1-7, baris 1-4 (nullable supaya buku lama tidak error)
            $table->unsignedTinyInteger("rack_number")->nullable()->after("stock");
            $table->unsignedTinyInteger("shelf_row")->nullable()->after("rack_number");
        });
    }

    public function down(): void
    {
        Schema::table("books", function (Blueprint $table) {
            $table->dropColumn(["rack_number", "shelf_row"]);
        });
    }
};