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

        Schema::create('favorite_appartments_table', function (Blueprint $table) {
            $table->id();
            $table->foreign('tenant_id')->references("id")->on("users");
            $table->foreign('appartment_id')->references("id")->on("appartments");
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_appartments_table');
    }
};
