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
        Schema::create('ticket_support_staff', function (Blueprint $table) {

            $table->foreignId('ticket_id')
                  ->constrained('tickets')
                  ->onDelete('cascade')
                  ->comment('Reference to the ticket');
            
            $table->foreignId('support_staff_id')
                  ->constrained('support_staff')
                  ->onDelete('cascade')
                  ->comment('Reference to the support staff member');      


            $table->primary(['ticket_id', 'support_staff_id']);
                  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_support_staff');
    }
};
