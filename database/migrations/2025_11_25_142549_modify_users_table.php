<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove email and add phone
            // $table->dropColumn('email');
            // $table->dropColumn('email_verified_at');

            // Add our custom fields
            $table->string('phone')->unique();
            $table->enum('role', ['tenant', 'owner', 'admin'])->default('tenant');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('profile_image')->nullable();
            $table->date('birth_date');
            $table->string('id_image')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamp('approved_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
