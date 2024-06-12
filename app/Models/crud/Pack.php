<?php

namespace App\Models\crud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use NumberFormatter;

class Pack extends Model
{
    use SoftDeletes;
    protected $table = 'pack';
    protected $primaryKey = 'id_pack';

///Validation requetes
    public function setNom($nom) {
        if (!isset($nom) || empty($nom) || !is_string($nom)) {
            throw new Exception('Veuillez entrer une chaine de caractere dans le champ nom');
        }
        $this->nom = $nom;
    }

    public function setPrixUnitaire($prixUnitaire) {
        if (!isset($prixUnitaire) || !is_numeric($prixUnitaire)) {
            throw new Exception('Veuillez entrer un nombre dans le champ prix unitaire');
        }
        $this->prix_unitaire = $prixUnitaire;
    }

    public function setPhoto(Request $request)
    {
            $request->validate([
                'photo' => 'required|file|mimes:jpeg,png,jpg,gif,svg', // Types de fichiers autorisés : jpeg, png, jpg, gif, svg | Taille maximale : 2048 kilo-octets
            ]);
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $fileName = $file->getClientOriginalName();
                $file->move(public_path('images/pack'), $fileName);
                $this->photo = $fileName;
            } else {
                throw new Exception('Erreur d\'upload ficher');
            }
    }

    public function setDescription($description) {
        $this->description = $description;
    }

///Fonction
    public static function isMatierePremiereExist($idMatierePremiere, $list) {
        foreach($list as $item) {
            Log::debug('Id matiere premiere = '.$item->getIdMatierePremiere());

            if($idMatierePremiere == $item->getIdMatierePremiere()) {
                return $list->search($item);
            } 
        }

        return null;
    }

    public function getFormatMonetaire($number) {
        $formatter = new NumberFormatter('fr_FR', NumberFormatter::CURRENCY);
        $montantFormate = $formatter->formatCurrency($number, 'Ariary');

        return $montantFormate;
    }
}
