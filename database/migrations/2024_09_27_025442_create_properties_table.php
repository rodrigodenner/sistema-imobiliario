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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relacionamento com users
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Relacionamento com categories
            $table->string('title', 115);
            $table->decimal('price', 10, 2);
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('garage_spaces')->nullable();
            $table->decimal('total_area', 10, 2)->nullable();
            $table->decimal('usable_area', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->boolean('featured')->default(false);
            $table->string('neighborhood', 255)->nullable();
            $table->string('city', 255);
            $table->string('CEP')->nullable();
            $table->string('slug', 150)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
