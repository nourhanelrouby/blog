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
        Schema::create('setting_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('setting_id');
            $table->string('locale')->index();

            $table->string('name')->nullable(false);
            $table->text('content')->nullable(false);
            $table->text('address')->nullable(false);

            $table->unique(['locale', 'setting_id']);
            $table->foreign('setting_id')->references('id')
                ->on('settings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_translations');
    }
};
