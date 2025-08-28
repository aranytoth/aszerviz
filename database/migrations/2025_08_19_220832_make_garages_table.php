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
        Schema::create('garages', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('website')->nullable();
            $table->integer('zip');
            $table->string('city');
            $table->string('address');
            $table->string('housenum');
            $table->uuid('company_id')->index();
            $table->integer('status')->default(10);
            $table->timestamps();
        });

        Schema::create('company', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->string('company_name')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_tax_number')->nullable();
            $table->string('company_zip')->nullable();
            $table->string('company_city')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_house_num')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('szamlazz_api_key')->nullable();
            $table->string('prefix');
            $table->integer('status')->default(10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garages');
        Schema::dropIfExists('company');
    }
};
