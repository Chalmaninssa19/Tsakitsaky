<?php

namespace App\Models\crud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class Unite extends Model
{
    protected $table = 'unite';
    protected $primaryKey = 'id_unite';

//Verfier si le nom existe deja
    public static function isExist($nom) {
        try {
            $req = "SELECT * FROM unite WHERE nom = '%s' LIMIT 1";
            $req = sprintf($req,$nom);
            $results = DB::select($req);
            $i = 0;
            if($results) {
                foreach ($results as $row) {
                    if($row->etat == 0) {
                       return $row->id_unite;
                    } else {
                        throw new Exception("Ce nom existe deja, veuillez inserer un autre");
                    }
                }
            }

            return null;
        } catch(Exception $e) {
            throw $e;
        }
    } 
}
