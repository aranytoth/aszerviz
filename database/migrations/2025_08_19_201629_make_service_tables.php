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
        Schema::create('clients', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('name')->index();
            $table->string('email')->index();
            $table->string('phone')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_vat')->nullable();
            $table->integer('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('housenum')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('worksheet', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('worksheet_id')->index();
            $table->uuid('garage_id')->index();
            $table->uuid('client_id')->nullable()->index();
            $table->uuid('vehicle_id')->nullable()->index();
            $table->string('name')->nullable()->index();
            $table->integer('status')->index()->default(1);
            $table->uuid('mechanic_user_id')->index();
            $table->integer('station_id')->index();
            $table->text('note')->nullable();
            $table->integer('calc_price')->nullable();
            $table->boolean('warranty')->default(1);
            $table->boolean('old_parts')->default(1);
            $table->timestamps();
        });

        Schema::create('worksheet_items', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->uuid('worksheet_id')->index();
            $table->string('item_num')->index();
            $table->string('item_name')->index();
            $table->double('quantity')->nullable();
            $table->integer('unit');
            $table->integer('unit_price')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('vat')->nullable();
            $table->boolean('is_work')->default(0);
            $table->timestamps();
        });

        Schema::create('vehicles', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('license_plate')->index();
            $table->string('validity_date')->index()->nullable();
            $table->string('brand')->index()->nullable();
            $table->string('chasis_num')->nullable();
            $table->string('man_year')->nullable();
            $table->integer('speedometer')->nullable();
            $table->string('engine_code')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('worksheet');
        Schema::dropIfExists('worksheet_items');
    }
};
