<?php

namespace App\Models\crud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class MatierePremierePack extends Model
{
    protected $table = 'matiere_premiere_pack';
    protected $primaryKey = 'id_matiere_premiere_pack';

///Validation
    public function setMatierePremiere($matierePremiere) {
        if (!isset($matierePremiere) || !is_numeric($matierePremiere)) {
            throw new Exception('Veuillez entrer un nombre dans le champ matiere premiere');
        }
        $this->matiere_premiere_id = $matierePremiere;
    }
    public function setQuantite($quantite) {
        if (!isset($quantite) || !is_numeric($quantite)) {
            throw new Exception('Veuillez entrer un nombre dans le champ quantite');
        }
        $this->quantite = $quantite;
    }

///Fonctions
    public static function deleteMPQtePack($id_pack, $id_matiere_premiere) {
        try {
            $req = "DELETE FROM matiere_premiere_pack WHERE pack_id = %d AND matiere_premiere_id = %d";
            $req = sprintf($req,$id_pack, $id_matiere_premiere);
            DB::delete($req);    
        } catch(Exception $e) {
            throw $e;
        }
    } 
}
