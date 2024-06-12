<?php

namespace App\Models\crud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;

class MatierePremiere extends Model
{
    protected $table = 'matiere_premiere';
    protected $primaryKey = 'id_matiere_premiere';

    public function setDesignation($designation) {
        if (!isset($designation) || empty($designation) || !is_string($designation)) {
            throw new Exception('Veuillez entrer une chaine de caractere dans le champ designation');
        }
        $this->designation = $designation;
    }

    public function setUnite($unite) {
        if (!isset($unite) || !is_numeric($unite)) {
            throw new Exception('Veuillez entrer un nombre dans le champ unite');
        }
        $this->unite_id = $unite;
    }

    public function setPrixUnitaire($prixUnitaire) {
        if (!isset($prixUnitaire) || !is_numeric($prixUnitaire)) {
            throw new Exception('Veuillez entrer un nombre dans le champ prix unitaire');
        }
        $this->prix_unitaire = $prixUnitaire;
    }
}
