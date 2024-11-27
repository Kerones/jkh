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
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->dateTimeTz('last_used_at')->nullable()->change();
            $table->dateTimeTz('expires_at')->nullable()->change();
            $table->dateTimeTz('created_at')->nullable()->change();
            $table->dateTimeTz('updated_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->timestamp('last_used_at')->nullable()->change();
            $table->timestamp('expires_at')->nullable()->change();
            $table->timestamp('created_at')->nullable()->change();
            $table->timestamp('updated_at')->nullable()->change();
        });
    }
};
