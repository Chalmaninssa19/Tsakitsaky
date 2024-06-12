<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\crud\MatierePremiere;
use App\Models\crud\VMatierePremiereUnite;
use App\Models\crud\Unite;
use Exception;

class MatierePremiereController extends Controller
{
    //Liste des matieres premieres
    public function listMatierePremiere()
    {
        //Verfier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
  
        $css = ['css/styleTable.css'];
        $js = ['js/script-table-tri.js'];
        $contentPage = 'pages/crud/matiere_premiere';
        $list = null;
        $uniteList = null;
        $page = 1;
        try {
            $uniteList = Unite::where('etat', 1)->get();
            $list = VMatierePremiereUnite::where('etat', 1)->paginate(4);

            if(isset($_GET['page'])) {
                $page=$_GET['page'];
            }
            
            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }

            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'list' => $list,
                'uniteList' => $uniteList,
                'page' => $page
            ]);
        } catch(Exception $e) {
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'list' => $list,
                'error' => $e->getMessage(),
                'uniteList' => $uniteList,
                'page' => $page
            ]);
        }       
    }

    //Enregistrer matiere premiere
    public function save(Request $request)
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
        try {
            $matierePremiere = new MatierePremiere;
            $matierePremiere->setDesignation($request->input('designation'));
            $matierePremiere->setUnite($request->input('unite_id'));
            $matierePremiere->setPrixUnitaire($request->input('prix_unitaire'));
            $matierePremiere->etat = 1;
 
            $matierePremiere->save();
        } catch(Exception $e) {  
            return redirect()->route('matiere_premiere', (['error' => $e->getMessage()]));
        }
 
        return redirect()->route('matiere_premiere');
    }

    //Supprimer matiere premiere
    public function delete(Request $request)
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
        
        try {
            $matierePremiere = MatierePremiere::find($request->id_matiere_premiere);
            $matierePremiere->etat = 0;
            $matierePremiere->save();
        } catch(Exception $e) {  
            return redirect()->route('matiere_premiere', (['error' => $e->getMessage()]));
        }

        return redirect()->route('matiere_premiere');
    }

    //Modifier matiere premiere
    public function edit(Request $request)
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
          
        $css = ['css/styleTable.css'];
        $js = ['js/script-table-tri.js'];
        $contentPage = 'pages/crud/matiere_premiere';
        $matierePremiere = null;
        $list = null;
        $page = 1;
        try {
            if(isset($_GET['id_matiere_premiere'])) {
                $matierePremiere = MatierePremiere::find($_GET['id_matiere_premiere']);
            } else {
                $matierePremiere = MatierePremiere::find($request->id_matiere_premiere);
            }
             
            $list = VMatierePremiereUnite::where('etat', 1)->paginate(4);
            $uniteList = Unite::where('etat', 1)->get();
 
            if(isset($_GET['page'])) {
                $page=$_GET['page'];
            }
            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }
 
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'list' => $list,
                'matierePremiere' => $matierePremiere,
                'uniteList' => $uniteList,
                'page' => $page
            ]);
 
        } catch(Exception $e) {  
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'list' => $list,
                'matierePremiere' => $matierePremiere,
                'error' => $e->getMessage(),
                'uniteList' => $uniteList,
                'page' => $page
            ]);
        } 
    }

    //Mettre a jour matiere premiere
    public function update(Request $request)
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
         
        try {
            $validatedData = $request->validate([
                'designation' => 'required|string',
                'unite_id' => 'required|numeric',
                'prix_unitaire' => 'required|numeric',
            ], [
                'required' => 'Le champ :attribute est obligatoire.',
                'string' => 'Le champ :attribute doit être une chaîne de caractères.',
                'numeric' => 'Le champ :attribute doit être un nombre.',
            ]);
            
            $matierePremiere = MatierePremiere::find($request->id_matiere_premiere);
            $matierePremiere->designation = $validatedData['designation'];
            $matierePremiere->unite_id = $validatedData['unite_id'];
            $matierePremiere->prix_unitaire = $validatedData['prix_unitaire'];
            $matierePremiere->etat = 1;
 
            $matierePremiere->save();
        } catch(Exception $e) {  
            return redirect()->route('edit', (['error' => $e->getMessage(), 'id_matiere_premiere' => $request->id_matiere_premiere]));
        }
 
        return redirect()->route('matiere_premiere');
     }

     public function tri(Request $request) {
        $colonneTri = $request->colonne;
        $ordreTri = $request->ordre;

        //$donnees = VMatierePremiereUnite::orderBy($colonneTri, $ordreTri)->get();
        $list = VMatierePremiereUnite::where('etat', 1)
                                    ->orderBy($colonneTri, $ordreTri)
                                    ->get();

        return response()->json($list);
    }
}
