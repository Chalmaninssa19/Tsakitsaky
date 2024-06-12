<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\crud\MatierePremiere;
use App\Models\crud\Pack;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('matiere_premiere_pack', function (Blueprint $table) {
            $table->id('id_matiere_premiere_pack');
            $table->foreignIdFor(MatierePremiere::class);
            $table->foreignIdFor(Pack::class);
            $table->decimal('quantite', 8, 2);
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
