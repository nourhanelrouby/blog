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
        Schema::create('post_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->string('locale')->index();

            $table->string('title')->nullable(false);
            $table->text('small_description')->nullable(false);
            $table->text('content')->nullable(false);

            $table->unique(['post_id', 'locale']);  // Composite
            $table->foreign('post_id')->references('id')
                ->on('posts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_translations');
    }
};
