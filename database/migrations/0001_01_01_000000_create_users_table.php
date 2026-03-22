<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Hier maak ik mijn 'users' tabel aan. 
 * Dit is de basis voor iedereen die op het platform komt.
 */
return new class extends Migration
{
    /**
     * De 'up' methode bouwt de tabellen in mijn database.
     * Ik gebruik het 'Blueprint' object om de kolommen te definiëren.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Maakt een uniek ID (Primary Key) voor elke gebruiker.
            $table->string('name');
            $table->string('email')->unique(); // 'unique' zorgt dat niemand met dezelfde email kan registreren.
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // Kolom voor rollen: ik gebruik 'student' als standaardwaarde.
            $table->string('role')->default('student'); 
            
            // Hier kan de admin later gebruikers mee blokkeren.
            $table->string('status')->default('active'); 
            
            $table->rememberToken(); // Voor de 'onthou mij' functie bij het inloggen.
            $table->timestamps(); // Maakt automatisch 'created_at' en 'updated_at' kolommen.
        });

        // Standaard Laravel tabellen voor password reset en sessies.
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * De 'down' methode verwijdert de tabellen weer bij een rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
