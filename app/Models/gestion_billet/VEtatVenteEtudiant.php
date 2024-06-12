<?php

namespace App\Models\gestion_billet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VEtatVenteEtudiant extends Model
{
    use HasFactory;
    protected $table = 'v_etat_vente_etudiant';

    public static function totalMontantMpNecessaire() {
        try {

            $req = "select sum(montant_mp_necessaire) total_montant_mp_necessaire from v_etat_vente_etudiant";
            $req = sprintf($req);
            $results = DB::select($req);
            $i = 0;
            if($results) {
                foreach ($results as $row) {
                  return $row->total_montant_mp_necessaire;
                }
            }

            return null;
        } catch(Exception $e) {
            throw $e;
        }
    } 

    public static function totalEtatVente() {
        try {

            $req = "select sum(quantite) quantite_total, sum(montant_billet) montant_billet_total, 
            sum(montant_billet) - sum(montant_mp_necessaire) total_benefice from v_etat_vente_etudiant";
            $req = sprintf($req);
            $results = DB::select($req);
            $i = 0;
            if($results) {
                foreach ($results as $row) {
                  return $row;
                }
            }

            return null;
        } catch(Exception $e) {
            throw $e;
        }
    } 
}
