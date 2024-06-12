<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\crud\Unite;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('matiere_premiere', function (Blueprint $table) {
            $table->id('id_matiere_premiere');
            $table->string('designation');
            $table->foreignIdFor(Unite::class);
            $table->decimal('prix_unitaire', 8, 2);
            $table->integer('etat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
