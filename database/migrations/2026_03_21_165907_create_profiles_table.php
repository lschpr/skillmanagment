<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Mijn extra profielgegevens tabel.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            // Koppelen aan de users tabel.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->text('bio')->nullable();
            $table->text('skills')->nullable(); // Alleen voor studenten.
            $table->string('location')->nullable();
            $table->string('logo_path')->nullable(); // Alleen voor bedrijven.
            $table->string('cv_path')->nullable();   // Alleen voor studenten.
            $table->string('website')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
