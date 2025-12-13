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
        Schema::disableForeignKeyConstraints();

        Schema::create('appartments', function (Blueprint $table) {
            $table->id();
            $table->foreign('owner_id')->references('id')->on('users')->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->decimal('price_per_night', 10, 2);
            $table->decimal('price_per_month', 10, 2);
            $table->integer('max_guests')->nullable();
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->text('address');
            $table->text('governorate');
            $table->enum('city', [""]);
            $table->decimal('latitude')->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('is_available')->default(true);
            $table->enum('status', ["approved", "rejected", "pending"])->default("pending");

            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appartments');
    }
};
