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
        Schema::create('budgets_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_id')->constrained();
            $table->foreignId('article_id')->constrained();
            $table->integer('amount');
            $table->decimal('price_unit', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets_details');
    }
};
