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
        Schema::create('order_tracking_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrier_id')->constrained('carriers')->onDelete('cascade'); // Relacionamento com pedidos
            $table->text('status'); // Status do pedido no momento
            $table->text('description'); // Status do pedido no momento
            $table->string('location')->nullable(); // Localização onde a atualização ocorreu
            $table->string('type')->nullable(); // Tipo de localização
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_tracking_history');
    }
};
