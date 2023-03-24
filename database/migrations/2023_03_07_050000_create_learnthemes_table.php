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
        Schema::create('learnthemes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("big_theme");
            $table->text("small_theme");
            $table->text("contents")->nullable();
            $table->text("reference")->nullable();
            $table->text("url")->nullable();
            $table->boolean("is_mastered")->default(false);
            $table->text("conscious")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learnthemes');
    }
};
