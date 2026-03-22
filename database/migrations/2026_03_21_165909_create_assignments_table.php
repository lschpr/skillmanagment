<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Hier maak ik de tabel voor alle opdrachten (vacatures).
     */
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            
            // Koppeling naar de user (het bedrijf). 
            // Cascade zorgt dat als het bedrijf weg gaat, de opdrachten ook verdwijnen.
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            $table->string('title');
            $table->text('description');
            $table->string('type'); // Bijv. stage of freelance.
            $table->string('region');
            $table->string('status')->default('open'); // Standaard staat een opdracht op 'open'.
            
            $table->timestamps();
        });
    }

    /**
     * Tabel weer verwijderen als ik een rollback doe.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
