<?php

namespace App\Models\gestion_billet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Exception;
use Carbon\Carbon;

class ImportVenteBillet extends Model
{
    use HasFactory;

    protected $table = 'import_vente_billet';
    private $errors = array();

///Getters et setters
    public function setCodePack($code_pack, $row) {
        if (!isset($code_pack) || empty($code_pack) || !is_string($code_pack)) {
            $this->errors[] = 'Erreur ligne '.$row.' : veuillez entrer une chaine de caractere dans le champ code_pack'; 
            //throw new Exception('Veuillez entrer une chaine de caractere dans le champ code_pack');
        }
        $this->code_pack = $code_pack;
    }

    public function setQuantite($quantite, $row) {
        if (!isset($quantite) || !is_numeric($quantite)) {
            $this->errors[] = 'Erreur ligne '.$row.' : veuillez entrer un nombre dans le champ quantite'; 
            //throw new Exception('Veuillez entrer un nombre dans le champ quantite');
        }
        if($quantite < 0) {
            $this->errors[] = 'Erreur ligne '.$row.' : valeur de quantite doit etre positive'; 
            //throw new Exception('Valeur de quantite doit etre positive');
        }
        $this->quantite = $quantite;
    }

    public function setCodeVendeur($code_vendeur, $row) {
        if (!isset($code_vendeur) || empty($code_vendeur) || !is_string($code_vendeur)) {
            $this->errors[] = 'Erreur ligne '.$row.' : veuillez entrer une chaine de caractere dans le champ code_vendeur'; 
            //throw new Exception('Veuillez entrer une chaine de caractere dans le champ code_vendeur');
        }
        $this->code_vendeur = $code_vendeur;
    }

    public function setAxeLivraison($axe_livraison, $row) {
        if (!isset($axe_livraison) || empty($axe_livraison) || !is_string($axe_livraison)) {
            $this->errors[] = 'Erreur ligne '.$row. ' : veuillez entrer une chaine de caractere dans le champ axe_livraison'; 
            //throw new Exception('Veuillez entrer une chaine de caractere dans le champ axe_livraison');
        }
        $this->axe_livraison = $axe_livraison;
    }

    public function setDate($date, $row) {
        $dateValider = Carbon::createFromFormat('d/m/Y', $date);

        if($dateValider == false) {
            $this->errors[] = 'Erreur ligne '.$row. ' : le format de date donne ne peur etre formatter'; 
            //throw new Exception('Le format de date donne ne peur etre formatter');
        }
        $date = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        if(!isset($date) || !strtotime($date)) {
            $this->errors[] = 'Erreur ligne '.$row.' : le champ date doit etre une date valide au format annee-mois-jour'; 
            //throw new Exception('Le champ date doit etre une date valide au format annee-mois-jour');
        } else {
            $dateParts = explode('-', $date);
            if(count($dateParts) != 3 || !checkdate($dateParts[1], $dateParts[2], $dateParts[0])) {
                $this->errors[] = 'Erreur ligne '.$row.' : le champ date doit etre au format annee-mois-jour'; 
                //throw new Exception('Le champ date doit etre au format annee-mois-jour');
            }
        }

        $this->date = $date;
    }

///Valider importation
    public static function makeErrorMessage($importVenteBillet) {
        $errorMessage = 'Erreurs rencontres lors de la lecture du fichier csv : ';
        foreach($importVenteBillet->errors as $error) {
            $errorMessage = $errorMessage.' -'.$error.';';
        }

        return $errorMessage;
    }

    public static function valideData($datas)
    {
        $row = 1;
        try {
            $importVenteBillet = new ImportVenteBillet();

            foreach($datas as $column){
                $date = $column[0];
                $code_pack = $column[1];
                $quantite = $column[2];
                $code_vendeur = $column[3];
                $axe_livraison = $column[4];
                
                $importVenteBillet->setDate($date, $row);
                $importVenteBillet->setCodePack($code_pack, $row);
                $importVenteBillet->setQuantite($quantite, $row);
                $importVenteBillet->setCodeVendeur($code_vendeur, $row);
                $importVenteBillet->setAxeLivraison($axe_livraison, $row);
    
                $row++;
            }

            if(count($importVenteBillet->errors) > 0) {
                $errorMessage = ImportVenteBillet::makeErrorMessage($importVenteBillet);
                throw new Exception($errorMessage);
            } else {
                $row = 1;
                foreach($datas as $column){
                    $date = $column[0];
                    $code_pack = $column[1];
                    $quantite = $column[2];
                    $code_vendeur = $column[3];
                    $axe_livraison = $column[4];
                    
                    $importVenteBillet = new ImportVenteBillet();
                    $importVenteBillet->setDate($date, $row);
                    $importVenteBillet->setCodePack($code_pack, $row);
                    $importVenteBillet->setQuantite($quantite, $row);
                    $importVenteBillet->setCodeVendeur($code_vendeur, $row);
                    $importVenteBillet->setAxeLivraison($axe_livraison, $row);
        
                    $importVenteBillet->save();
                    $row++;
                }
            }
        } catch(Exception $e) {
            //Log::debug('erreur = '.$e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}
