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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('slug')->unique()->after('name')->index();
            $table->timestamps();
        });

        Schema::create('page_tag', function (Blueprint $table) {
            $table->id();
            $table->integer('page_id')->unsigned();
            $table->integer('tag_id')->unsigned();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('slug')->unique()->after('name')->index();
            $table->integer('order')->default(0);
            $table->integer('parent_id')->default(0)->index();
            $table->timestamps();
        });

        Schema::create('page_category', function (Blueprint $table) {
            $table->id();
            $table->integer('page_id')->unsigned();
            $table->integer('category_id')->unsigned();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void 
    {
        Schema::dropIfExists('page_category');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('page_tag');
        Schema::dropIfExists('tags');
    }
};
