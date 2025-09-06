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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->integer('type')->index()->after('brand')->default(1);
            $table->integer('fuel_type')->index()->after('type')->default(1);
            $table->integer('kilowatt')->after('fuel_type')->nullable();
        });

        Schema::table('worksheet_items', function(Blueprint $table){
            $table->uuid('worker_user_id')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('type', 'fuel_type', 'kilowatt');
        });
        Schema::table('worksheet_items', function(Blueprint $table){
            $table->dropColumn('worker_user_id');
        });
    }
};
