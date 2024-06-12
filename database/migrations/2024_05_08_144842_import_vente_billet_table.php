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
        Schema::create('import_vente_billet', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('code_pack');
            $table->string('pack');
            $table->decimal('quantite', 8, 2);
            $table->string('code_vendeur');
            $table->string('axe_livraison');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_vente_billet');
    }
};
