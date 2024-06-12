<?php

namespace App\Models\crud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VMatierePremiereQuantite extends Model
{
    protected $table = 'v_matiere_premiere_quantite';

///Fonctions
    public static function findMPQtePack($id_pack) {
        try {
            $req = "SELECT id_matiere_premiere, designation, unite, sum(quantite) quantite 
            FROM v_matiere_premiere_quantite WHERE pack_id = %d GROUP BY id_matiere_premiere, designation, unite";
            $req = sprintf($req,$id_pack);
            $results = DB::select($req);
            $datas = array();
            $i = 0;
            foreach ($results as $row) {
                $datas[$i] = $row;
                $i++;
            }
     
            return $datas;
        } catch(Exception $e) {
            throw $e;
        }
    } 
}
