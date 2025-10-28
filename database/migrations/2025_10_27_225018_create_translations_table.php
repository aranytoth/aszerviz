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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // pl. 'read_more'
            $table->string('group')->default('common'); // pl. 'navigation', 'buttons'
            $table->timestamps();
        });

        Schema::create('translation_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('translation_id')->constrained()->onDelete('cascade');
            $table->string('lang', 5);
            $table->text('value');
            
            $table->unique(['translation_id', 'lang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
        Schema::dropIfExists('translation_values');
    }
};
