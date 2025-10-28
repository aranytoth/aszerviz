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
            
            $table->text('lead')->nullable()->after('title');
            $table->string('slug')->unique()->after('lead');
            $table->text('content')->nullable()->after('slug');
            $table->string('lead_image')->nullable()->after('content');
            $table->integer('order')->default(0);
            $table->integer('parent_id')->nullable()->after('order');
            $table->integer('status')->default(1)->after('parent_id');
            $table->integer('type')->default(0)->after('status');
            $table->json('additional')->nullable()->after('lead_image');
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
