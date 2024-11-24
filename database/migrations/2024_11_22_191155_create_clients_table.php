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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('postcode');
            $table->string('gezinsnaam');
            $table->string('adres');
            $table->string('email')->unique();
            $table->string('telefoonnummer');
            $table->integer('volwassenen')->nullable();
            $table->integer('kinderen')->nullable();
            $table->integer('babys')->nullable();
            $table->boolean('is_klant');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
