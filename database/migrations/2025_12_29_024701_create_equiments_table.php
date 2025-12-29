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
        Schema::create('equiments', function (Blueprint $table) {
            $table->id();

            $table->string('brand')
                  ->nullable()
                  ->comment('Brand of the equipment');

            $table->string('model')
                  ->nullable()
                  ->comment('Model of the equipment');
            
            $table->string('serial')
                  ->nullable()
                  ->comment('Serial number of the equipment');

            $table->string('code')
                  ->nullable()
                  ->comment('Internal code of the equipment');
                  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equiments');
    }
};
