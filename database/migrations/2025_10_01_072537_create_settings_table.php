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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable(true);
            $table->string('favicon')->nullable(true);
            $table->string('facebook')->nullable(true);
            $table->string('twitter')->nullable(true);
            $table->string('instagram')->nullable(true);
            $table->string('linkedin')->nullable(true);
            $table->string('phone')->nullable(true);
            $table->string('email')->nullable(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
