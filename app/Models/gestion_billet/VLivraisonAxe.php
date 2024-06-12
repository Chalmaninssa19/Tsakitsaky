<?php

namespace App\Models\gestion_billet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VLivraisonAxe extends Model
{
    use HasFactory;
    protected $table = 'v_livraison_axe';

    public static function getDetailLivraisonAxe($id_axe_livraison) {
        try {
            $req = "SELECT nom_client, contact_client, nom_etudiant, prenom_etudiant, pack, quantite,
            (quantite * prix_unitaire)::NUMERIC(10, 2) AS montant FROM v_vente_billet_etudiant_details 
            WHERE id_axe_livraison  = %d";
            $req = sprintf($req, $id_axe_livraison);
            $results = DB::select($req);
            $i = 0;
            $list = array();
            if($results) {
                foreach ($results as $row) {
                  $list[$i] = $row;
                  $i++;
                }
            }

            return $list;
        } catch(Exception $e) {
            throw $e;
        }
    } 

    public static function getLivraisonAxe($id_axe_livraison) {
        try {
            Log::debug('Tafiditra livraison axe');

            $req = "SELECT id_axe_livraison, nom_axe, axe, COALESCE(SUM(quantite), 0)::NUMERIC(10, 2) AS total_livraison,
            COALESCE(SUM(quantite*prix_unitaire), 0)::NUMERIC(10, 2) AS total_montant FROM v_vente_billet_etudiant_details
            WHERE id_axe_livraison  = %d group by nom_axe, axe, id_axe_livraison LIMIT 1";
            $req = sprintf($req, $id_axe_livraison);
            $results = DB::select($req);
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
