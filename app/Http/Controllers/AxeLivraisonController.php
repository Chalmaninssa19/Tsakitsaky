<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\crud\AxeLivraison;
use Exception;

class AxeLivraisonController extends Controller
{
    //Liste axe delivraison
    public function listAxeLivraison()
    {
        //Verfier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }

        $css = [];
        $js = [];
        $contentPage = 'pages/crud/axe_livraison';
        $listAxeLivraison = null;
      
        try {
            $listAxeLivraison = AxeLivraison::where('etat', 1)->get();

            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }
      
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'listAxeLivraison' => $listAxeLivraison
            ]);
        } catch(Exception $e) {
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'listAxeLivraison' => $listAxeLivraison,
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
            $axeLivraison = new AxeLivraison;
            $axeLivraison->setNom($request->input('nom'));
            $axeLivraison->setAxe($request->input('axe'));
            $axeLivraison->etat = 1;
 
            $axeLivraison->save();
          
        } catch(Exception $e) {  
            return redirect()->route('axe_livraison', (['error' => $e->getMessage()]));
        }

        return redirect()->route('axe_livraison');
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
            $axeLivraison = AxeLivraison::find($request->id_axe_livraison);
            $axeLivraison->etat = 0;
            $axeLivraison->save();
        } catch(Exception $e) {  
            return redirect()->route('axe_livraison', (['error' => $e->getMessage()]));
        }

        return redirect()->route('axe_livraison');
    }
}
