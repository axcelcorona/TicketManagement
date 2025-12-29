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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            // Relacion de los tickets con los usuarios
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Informacion General del ticket
            $table->string('client_name')
                  ->nullable()
                  ->comment('Name for the client associated with the ticket');

            $table->string('client_email')
                  ->nullable()
                  ->comment('Email for the client associated with the ticket');
            
            $table->string('owner_name')
                  ->nullable()
                  ->comment('Name of the owner associated with the ticket');

            $table->dateTime('call_time')
                  ->nullable()
                  ->comment('Time when the call was made regarding the ticket');
            
            $table->dateTime('start_time')
                  ->nullable()
                  ->comment('Time when work on the ticket started');
            
            $table->dateTime('end_time')
                  ->nullable()
                  ->comment('Time when work on the ticket ended');

            $table->string('status')
                  ->default('open')
                  ->comment('Current status of the ticket (e.g., open, in progress, closed)');

            $table->string('location')
                  ->nullable()
                  ->comment('Location related to the ticket');

            $table->text('problem_description')
                  ->nullable()
                  ->comment('Detailed description of the problem reported in the ticket');
            
            $table->text('solution_applied')
                  ->nullable()
                  ->comment('Solution applied to resolve the ticket');
            
            $table->text('observations')
                   ->nullable()
                   ->comment('Additional observations about the ticket');

            // Relaciones con otros modelos

            $table->foreignId('equiment_id')
                  ->nullable()
                  ->constrained('equiments')
                  ->onDelete('set null')
                  ->comment('Reference to the equipment related to the ticket');
            
            $table->foreignId('visit_type_id')
                  ->nullable()
                  ->constrained('visit_types')
                  ->onDelete('set null')
                  ->comment('Reference to the type of visit for the ticket');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
