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
        Schema::create('stock_entries', function (Blueprint $table) {
            $table->id();
            $table->string('stock_no')->unique();
            $table->string('item_code');
            $table->string('item_name');
            $table->integer('quantity');
            $table->string('location')->nullable();
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->date('in_stock_date');
            $table->enum('status', ['Pending', 'In-Stock', 'Out-Of-Stock'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_entries');
    }
};
