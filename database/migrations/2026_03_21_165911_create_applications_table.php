<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel voor alle sollicitaties van studenten.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            // De opdracht waar het om gaat.
            $table->foreignId('assignment_id')->constrained()->onDelete('cascade');
            
            // De student die reageert.
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            $table->text('message'); // De motivatiebrief van de student.
            $table->string('status')->default('pending'); // Bijv pending, accepted of rejected.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
