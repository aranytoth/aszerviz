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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            
            $table->text('lead')->nullable();
            $table->string('slug')->unique();
            $table->text('content')->nullable();
            $table->string('lead_image')->nullable();
            $table->integer('order')->default(0);
            $table->integer('parent_id')->nullable();
            $table->integer('status')->default(1);
            $table->integer('type')->default(0);
            $table->json('additional')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
