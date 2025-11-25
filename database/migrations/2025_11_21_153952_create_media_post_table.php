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
        Schema::create('media_entities', function (Blueprint $table) {
            $table->id();
            $table->string('entity_type')->index();
            $table->integer('entity_id')->constrained()->onDelete('cascade');
            // Mivel a Spatie 'media' táblája az id-t használja, hivatkozunk rá:
            $table->foreignId('media_id')->constrained('media')->onDelete('cascade'); 
            
            // Opcionális: Ha szeretnéd tudni, milyen szerepkörben van ott a kép (pl. 'gallery', 'cover')
            $table->string('type')->default('gallery')->index(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_post');
    }
};
