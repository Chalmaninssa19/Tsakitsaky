<?php

namespace App\Models\gestion_billet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;

class PaiementBillet extends Model
{
    use HasFactory;

    protected $table = 'paiement_billet';
    protected $primaryKey = 'id_paiement_billet';

///Validation
    public function setMontantPayer($montant_payer, $id_etudiant) {
        if (!isset($montant_payer) || !is_numeric($montant_payer)) {
            throw new Exception('Veuillez entrer un nombre dans le champ montant_payer');
        }
        $checkMontantPayer = $this->checkMontantPayer($id_etudiant, $montant_payer);
        
        if($checkMontantPayer == null) {
            $this->montant_paye = $montant_payer;
        } else {
            $this->montant_paye = $checkMontantPayer;
        }
    }

    public function setEtudiant($etudiant) {
        if (!isset($etudiant) || !is_numeric($etudiant)) {
            throw new Exception('Veuillez entrer un nombre dans le champ etudiant');
        }
        $this->etudiant_id = $etudiant;
    }

    public function setDatePaiement($date) {
        if(!isset($date) || !strtotime($date)) {
            throw new Exception('Le champ date doit etre une date valide au formatannee-mois-jour');
        } else {
            $dateParts = explode('-', $date);
            if(count($dateParts) != 3 || !checkdate($dateParts[1], $dateParts[2], $dateParts[0])) {
                throw new Exception('Le champ date doit etre au format annee-mois-jour');
            }
        }

        $this->date_paiement = $date;
    }

    public function checkMontantPayer($id_etudiant, $montant_payer) {
        try {
            $etatPaiement = VEtatPaiement::where('id_etudiant', $id_etudiant)->first();
            if($montant_payer == 0) {
                throw new Exception("Impossible d'effectuer cette operation : 
                les ventes de billets pour cet etudiant sont deja tous payes");
            }

            $diff = $etatPaiement->montant_reste_paye - $montant_payer; 
           
            if($diff <= 0) {
                return $diff;
            }

            return null;
        } catch(Exception $e) {
            throw $e;
        }
    }
}
