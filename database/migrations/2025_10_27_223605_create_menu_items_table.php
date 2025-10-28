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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('menu_key'); // pl. 'main', 'footer'
            $table->foreignId('parent_id')->nullable()->constrained('menu_items');
            $table->string('entity_type'); // pl. post, custom, category, tag
            $table->integer('entity_id')->nullable();
            $table->string('url')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('menu_item_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_item_id')->constrained()->onDelete('cascade');
            $table->string('lang', 5);
            $table->string('title');
            
            $table->unique(['menu_item_id', 'lang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('menu_item_translations');
    }
};
