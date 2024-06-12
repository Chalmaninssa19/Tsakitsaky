<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\crud\Unite;
use Exception;

class UniteController extends Controller
{
    //Liste unite
    public function listUnite()
    {
        //Verfier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }

        $css = ['asset(\'css/supplier/supplier.css\')'];
        $js = ['assets(\'js/bootstrap.bundle.min.js\')'];
        $contentPage = 'pages/crud/unite';
        $listUnite = null;
      
        try {
            $listUnite = Unite::where('etat', 1)->get();

            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }
      
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'listUnite' => $listUnite
            ]);
        } catch(Exception $e) {
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'listUnite' => $listUnite,
                'error' => $e->getMessage()
            ]);
        }       
    }

    //Enregistrer unite
    public function save(Request $request)
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }

        try {
            $validatedData = $request->validate([
                'nom' => 'required|string',
            ], [
                'required' => 'Le champ :attribute est obligatoire.',
                'string' => 'Le champ :attribute doit être une chaîne de caractères.',
            ]);

            $idUnite = Unite::isExist($validatedData['nom']);
            if($idUnite != null) {
                $unite = Unite::find($idUnite);
                $unite->etat = 1;
                $unite->save();
            } else {
                $unite = new Unite;
                $unite->nom = $validatedData['nom'];
                $unite->etat = 1;
    
                $unite->save();
            }
          
        } catch(Exception $e) {  
            return redirect()->route('unite', (['error' => $e->getMessage()]));
        }

        return redirect()->route('unite');
    }

    //Supprimer unite
    public function delete(Request $request)
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }

        try {
            $unite = Unite::find($request->id_unite);
            $unite->etat = 0;
            $unite->save();
        } catch(Exception $e) {  
            return redirect()->route('unite', (['error' => $e->getMessage()]));
        }

        return redirect()->route('unite');
    }
}
