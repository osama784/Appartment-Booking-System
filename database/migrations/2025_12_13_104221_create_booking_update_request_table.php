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

        Schema::create('booking_update_request', function (Blueprint $table) {
            $table->id();
            $table->foreign('booking_id')->references("id")->on("bookings")->cascadeOnDelete();
            $table->date('requested_start_date');
            $table->date('requested_end_date');
            $table->text('requested_tenant_notes');
            $table->integer('requested_number_of_guests');
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
        Schema::dropIfExists('booking_update_request');
    }
};
