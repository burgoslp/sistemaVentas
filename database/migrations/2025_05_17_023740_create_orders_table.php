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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Creador
            $table->foreignId('user_aprove')->nullable()->constrained('users'); // Aprobador
            $table->foreignId('client_id')->constrained(); // Creador
            $table->decimal('total_amount', 12, 2);
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamp('approved_at')->nullable();//cuando se aprobó
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
