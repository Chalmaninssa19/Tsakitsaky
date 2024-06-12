<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\crud\Etudiant;
use Exception;

class EtudiantController extends Controller
{
    //Liste type billet
    public function listEtudiant()
    {

        //Verfier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }

        $css = [];
        $js = ['assets(\'js/bootstrap.bundle.min.js\')'];
        $contentPage = 'pages/crud/etudiant';
        $list = null;

        try {
            $list = Etudiant::where('etat', 1)->get();

            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }

            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'list' => $list
            ]);
        } catch(Exception $e) {
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'list' => $list,
                'error' => $e->getMessage()
            ]);
        }       
    }

    //Enregistrer etudiant
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
                'prenom' => 'required|string',
                'email' => 'required|string',
                'contact' => 'required|string',
            ], [
                'required' => 'Le champ :attribute est obligatoire.',
                'string' => 'Le champ :attribute doit être une chaîne de caractères.',
            ]);
            $etudiant = new Etudiant;
            $etudiant->nom = $validatedData['nom'];
            $etudiant->prenom = $validatedData['prenom'];
            $etudiant->email = $validatedData['email'];
            $etudiant->contact = $validatedData['contact'];
            $etudiant->etat = 1;

            $etudiant->save();
          
        } catch(Exception $e) {  
            return redirect()->route('etudiant', (['error' => $e->getMessage()]));
        }

        return redirect()->route('etudiant');
    }

    //Supprimer etudiant
    public function delete(Request $request)
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
        
        try {
            $etudiant = Etudiant::find($request->id_etudiant);
            $etudiant->etat = 0;
            $etudiant->save();
        } catch(Exception $e) {  
            return redirect()->route('etudiant', (['error' => $e->getMessage()]));
        }

        return redirect()->route('etudiant');
    }


    //Modifier etudiant
    public function edit(Request $request)
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
         
        $css = ['asset(\'css/supplier/supplier.css\')'];
        $js = ['assets(\'js/bootstrap.bundle.min.js\')'];
        $contentPage = 'pages/crud/etudiant';
        $etudiant = null;
        $list = null;
      
        try {
            if(isset($_GET['id_etudiant'])) {
                $etudiant = Etudiant::find($_GET['id_etudiant']);
            } else {
                $etudiant = Etudiant::find($request->id_etudiant);
            }
            
            $list = etudiant::where('etat', 1)->get();

            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }

            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'list' => $list,
                'etudiant' => $etudiant
            ]);

        } catch(Exception $e) {  
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'list' => $list,
                'etudiant' => $etudiant,
                'error' => $e->getMessage()
            ]);
        } 
    }

    //Mettre a jour etudiant
    public function update(Request $request)
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
         
        try {
            $validatedData = $request->validate([
                'nom' => 'required|string',
                'prenom' => 'required|string',
                'email' => 'required|string',
                'contact' => 'required|string',
            ], [
                'required' => 'Le champ :attribute est obligatoire.',
                'string' => 'Le champ :attribute doit être une chaîne de caractères.',
            ]);
            
            $etudiant = Etudiant::find($request->id_etudiant);
            $etudiant->nom = $validatedData['nom'];
            $etudiant->prenom = $validatedData['prenom'];
            $etudiant->email = $validatedData['email'];
            $etudiant->contact = $validatedData['contact'];
            $etudiant->etat = 1;

            $etudiant->save();
        } catch(Exception $e) {  
            return redirect()->route('edit', (['error' => $e->getMessage(), 'id_etudiant' => $request->id_etudiant]));
        }
 
        return redirect()->route('etudiant');
    }
}
