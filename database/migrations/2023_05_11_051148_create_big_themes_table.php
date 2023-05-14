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
        Schema::create('big_themes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("big_theme");
            $table->boolean("cont_which")->default(false);
            // enumを後に増やすことを考えたら、初期ではstringで行い、バリデーションでenumする
            $table->string("file_which");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('big_themes');
    }
};
