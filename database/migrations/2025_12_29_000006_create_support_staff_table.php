<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('support_staff', function (Blueprint $table) {
            $table->id();

            $table->string('name')
                  ->nullable()
                  ->comment('Name of the support staff member');

            $table->string('email')
                  ->nullable()
                  ->unique()
                  ->comment('Email of the support staff member');
            
            $table->string('phone')
                  ->nullable()
                  ->unique()
                  ->comment('Phone number of the support staff member');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_staff');
    }
};
