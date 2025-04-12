<?php

use App\Enums\TravelOrderStatus;
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
        Schema::create('travel_orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // Armazenamos o destino como JSON (para o Value Object + Cast)
            $table->json('destino');

            // Enum como string (backed enum)
            $table->enum('status', TravelOrderStatus::values())->default(TravelOrderStatus::SOLICITADO->value);

            $table->date('data_ida');
            $table->date('data_volta');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_orders');
    }
};
