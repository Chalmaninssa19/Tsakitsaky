<?php

namespace App\Models\gestion_billet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VEtatPaiement extends Model
{
    use HasFactory;
    protected $table = 'v_etat_paiement';

///Fonctions
    public static function totalEtatPaiement() {
        try {

            $req = "SELECT sum(montant_deja_paye) total_deja_paye, 
            sum(montant_total_paye) total_paye, sum(montant_reste_paye) total_reste_paye 
            from v_etat_paiement LIMIT 1";
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
