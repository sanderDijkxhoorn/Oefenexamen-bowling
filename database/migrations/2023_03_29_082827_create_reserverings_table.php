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
        Schema::create('reserverings', function (Blueprint $table) {
            // Id
            $table->id();

            // Persoon id
            $table->foreignId('persoon_id')->constrained('persoon');

            // Pakket optie id nullable
            $table->foreignId('pakket_optie_id')->nullable()->constrained('pakket_optie');

            // Reserverings nummer
            $table->string('reserverings_nummer', 10);

            // Datum
            $table->date('datum');

            // AantalUren
            $table->integer('aantal_uren');

            // BeginTijd
            $table->time('begin_tijd');

            // EindTijd
            $table->time('eind_tijd');

            // AantalVolwassenen
            $table->integer('aantal_volwassenen');

            // AantalKinderen nullable
            $table->integer('aantal_kinderen')->nullable();

            // Timestamp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserverings');
    }
};
