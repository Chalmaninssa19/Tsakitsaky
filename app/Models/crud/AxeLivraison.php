<?php

namespace App\Models\crud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;

class AxeLivraison extends Model
{
    use HasFactory;
    protected $table = 'axe_livraison';
    protected $primaryKey = 'id_axe_livraison';

///Validation
    public function setNom($nom) {
        if (!isset($nom) || empty($nom) || !is_string($nom)) {
            throw new Exception('Veuillez entrer une chaine de caractere dans le champ nom');
        }
        $this->nom = $nom;
    }

    public function setAxe($axe) {
        if (!isset($axe) || empty($axe) || !is_string($axe)) {
            throw new Exception('Veuillez entrer une chaine de caractere dans le champ axe');
        }
        $this->axe = $axe;
    }
}
