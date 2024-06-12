<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\crud\Pack;
use App\Models\crud\Etudiant;
use App\Models\crud\AxeLivraison;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vente_billet', function (Blueprint $table) {
            $table->id('id_vente_billet');
            $table->foreignIdFor(Pack::class);
            $table->foreignIdFor(Etudiant::class);
            $table->foreignIdFor(AxeLivraison::class);
            $table->string('nom_client');
            $table->string('contact_client');
            $table->decimal('quantite', 8, 2);
            $table->date('date_vente');
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
