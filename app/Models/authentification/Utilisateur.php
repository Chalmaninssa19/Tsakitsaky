<?php

namespace App\Models\authentification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;
use App\Exceptions\ClientExceptionHandler;
use Illuminate\Support\Facades\DB;


class Utilisateur extends Model
{    
    use HasFactory;
    
    private $id_utilisateur;
    private $date_naissance;
    private $sexe;
    private $username;
    private $mdp;
    private $email;
    private $profil;

///Constructors
    public function __construct($id_utilisateur, $date_naissance, $sexe, $username, $mdp, $email, $profil)
    {
        $this->id_utilisateur = $id_utilisateur;
        $this->date_naissance = $date_naissance;
        $this->sexe = $sexe;
        $this->username = $username;
        $this->mdp = $mdp;
        $this->email = $email;
        $this->profil = $profil; 
    }

///Encapsulation

///Fonction
    ///S'Authentifier
    public static function authenticate($username, $mdp) {
        try {
            $req = "SELECT * FROM utilisateur WHERE mdp = '%s' AND username = '%s'";
            $req = sprintf($req,$mdp,$username);
            $results = DB::select($req);
            $i = 0;
            if($results) {
                foreach ($results as $row) {
                    return new Utilisateur($row->id_utilisateur, $row->date_naissance, $row->sexe, $row->username, $row->mdp, $row->email, Profil::findById($row->id_profil));
                }
            }
            throw new Exception("Verifier votre username et mot de passe");

        } catch(Exception $e) {
            throw $e;
        }
    }
}