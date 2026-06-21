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
        Schema::create('informacion_nutricional', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')
                ->constrained('productos')
                ->cascadeOnDelete();
            $table->unsignedInteger('calorias')->default(0);
            $table->decimal('proteina', 8, 2)->default(0);
            $table->decimal('carbohidratos', 8, 2)->default(0);
            $table->decimal('grasas', 8, 2)->default(0);
            $table->decimal('sodio', 8, 2)->default(0);
            $table->decimal('puntaje', 5, 2)->default(0);
            $table->unique('producto_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacion_nutricional');
    }
};
