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
        Schema::create('menus', function (Blueprint $table) {
              $table->id();
              $table->string('name');
              $table->decimal('price',12,2);
              $table->integer('stock')->nullable(); // UMKM only
              $table->enum('source',['internal','umkm']);
              $table->enum('status',['pending','approved','rejected'])->default('pending');
              $table->enum('availability',['open','closed'])->nullable(); // internal only
              $table->json('images')->nullable();
              $table->foreignId('created_by')->constrained('users');
              $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
