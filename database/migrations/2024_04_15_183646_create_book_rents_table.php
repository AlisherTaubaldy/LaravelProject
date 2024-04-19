<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_rents', function (Blueprint $table) {
            $table->id();
            $table->foreignId("book_id")->constrained()->onDelete("cascade");
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->dateTime("rental_date");
            $table->dateTime("return_date");
            $table->dateTime("returned_at")->nullable();
            $table->boolean("extended")->default(0);
            $table->dateTime("extended_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_rents');
    }
};
