<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\crud\Etudiant;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('paiement_billet', function (Blueprint $table) {
            $table->id('id_paiement_billet');
            $table->foreignIdFor(Etudiant::class);
            $table->decimal('montant_paye', 8, 2);
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
