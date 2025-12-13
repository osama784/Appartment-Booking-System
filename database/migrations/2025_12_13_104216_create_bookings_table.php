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

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreign('tenant_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('appartment_id')->references('id')->on('appartments')->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_price', 12, 2);
            $table->integer('number_of_guests')->nullable();
            $table->text('owner_notes')->nullable();
            $table->text('tenant_notes')->nullable();
            $table->enum('status', ["pending", "approved", "rejected", "cancelled", "completed"])->default("pending");
            $table->enum('payment_status', ["pending", "paid", "refunded", "failed"])->default("pending");
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
