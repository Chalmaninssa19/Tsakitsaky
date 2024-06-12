<?php

namespace App\Models\authentification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Profil extends Model
{
    use HasFactory;

    private $id_profil;
    private $libelle;

///Constructors
    public function __construct($id_profil, $libelle)
    {
        $this->id_profil = $id_profil;
        $this->libelle = $libelle;
    }

///Encapsulation
    public function getIdProfil()
    {
        return $this->id_profil;
    }
    public function setIdProfil($value)
    {
        $this->id_profil = $value;
    }
    public function getLibelle()
    {
        return $this->libelle;
    }
    public function setLibelle($value)
    {
        $this->libelle = $value;
    }

///Fonctions
    //Recuperer le profil correspondant au parametre id
    public static function findById($id)
    {
        $results = DB::table('profil')->where('id_profil', $id)->first();
    
        return new Profil($results->id_profil, $results->libelle);
    }  
}
