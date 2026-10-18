<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("transactions", function (Blueprint $table) {
            $table->id();
            $table->string("transaction_code")->unique();
            $table->foreignId("book_id")->constrained("books")->cascadeOnDelete();
            $table->foreignId("member_id")->constrained("members")->cascadeOnDelete();
            $table->foreignId("admin_id")->nullable()->constrained("users")->nullOnDelete();
            $table->date("borrow_date");
            $table->date("due_date");
            $table->date("return_date")->nullable();
            $table->enum("status", ["dipinjam", "dikembalikan", "terlambat"])->default("dipinjam");
            $table->unsignedInteger("fine")->default(0);
            $table->text("notes")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("transactions");
    }
};
