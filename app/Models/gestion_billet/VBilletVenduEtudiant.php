<?php

namespace App\Models\gestion_billet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VBilletVenduEtudiant extends Model
{
    use HasFactory;
    protected $table = 'v_billet_vendu_etudiant';

///Fonctions
    public function getMontantMp() {
        return $this->quantite * $this->montant_mp_necessaire_unitaire;
    }
}
