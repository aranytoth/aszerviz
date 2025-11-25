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
        Schema::create('pages_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->onDelete('cascade');
            $table->string('lang', 5);
            $table->string('title');
            $table->text('content');
            $table->timestamps();

            $table->unique(['page_id', 'lang']);
        });

        Schema::create('tags_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->string('lang', 5);
            $table->string('name');
            
            $table->unique(['tag_id', 'lang']);
        });

        Schema::create('categories_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('lang', 5);
            $table->string('name');
            
            $table->unique(['category_id', 'lang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages_translations');
        Schema::dropIfExists('tags_translations');
        Schema::dropIfExists('categories_translations');
    }
};
