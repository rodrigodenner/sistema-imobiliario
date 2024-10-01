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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20);
            $table->string('type');
            $table->string('address');
            $table->integer('bedrooms')->default(0);
            $table->string('neighborhood');
            $table->string('city');
            $table->string('state');
            $table->decimal('usable_area', 10, 2)->default(0.00);
            $table->decimal('total_area', 10, 2)->default(0.00);
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
