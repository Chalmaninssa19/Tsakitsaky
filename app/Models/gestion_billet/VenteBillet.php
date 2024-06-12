<?php

namespace App\Models\gestion_billet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;

class VenteBillet extends Model
{
    use HasFactory;
    protected $table = 'vente_billet';
    protected $primaryKey = 'id_vente_billet';

///Validation
    public function setQuantite($quantite) {
        if (!isset($quantite) || !is_numeric($quantite)) {
            throw new Exception('Veuillez entrer un nombre dans le champ quantite');
        }
        if($quantite < 0) {
            throw new Exception('Valeur de quantite doit etre positive');
        }
        $this->quantite = $quantite;
    }

    public function setEtudiant($etudiant) {
        if (!isset($etudiant) || !is_numeric($etudiant)) {
            throw new Exception('Veuillez entrer un nombre dans le champ etudiant');
        }
        $this->etudiant_id = $etudiant;
    }

    public function setBillet($billet) {
        if (!isset($billet) || !is_numeric($billet)) {
            throw new Exception('Veuillez entrer un nombre dans le champ billet vendu');
        }
        $this->pack_id = $billet;
    }

    public function setDate($date) {
        if(!isset($date) || !strtotime($date)) {
            throw new Exception('Le champ date doit etre une date valide au formatannee-mois-jour');
        } else {
            $dateParts = explode('-', $date);
            if(count($dateParts) != 3 || !checkdate($dateParts[1], $dateParts[2], $dateParts[0])) {
                throw new Exception('Le champ date doit etre au format annee-mois-jour');
            }
        }

        $this->date_vente = $date;
    }

    public function setNomClient($nom_client) {
        if (!isset($nom_client) || empty($nom_client) || !is_string($nom_client)) {
            throw new Exception('Veuillez entrer une chaine de caractere dans le champ nom client');
        }
        $this->nom_client = $nom_client;
    }

    public function setContactClient($contact_client) {
        if (!isset($contact_client) || empty($contact_client) || !is_string($contact_client)) {
            throw new Exception('Veuillez entrer une chaine de caractere dans le champ contact client');
        }
        $this->contact_client = $contact_client;
    }

    public function setAxeLivraison($axe_livraison) {
        if (!isset($axe_livraison) || !is_numeric($axe_livraison)) {
            throw new Exception('Veuillez entrer un nombre dans le champ axe livraison vendu');
        }
        $this->axe_livraison_id = $axe_livraison;
    }


}

