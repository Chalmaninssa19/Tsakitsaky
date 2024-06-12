<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\crud\Pack;
use App\Models\crud\VMatierePremiereUnite;
use App\Models\crud\VMatierePremiereQuantite;
use App\Models\crud\MatierePremiereQuantite;
use App\Models\crud\MatierePremierePack;
use App\Collections\MaCollection;
use Illuminate\Support\Facades\Log;

use Exception;

class PackController extends Controller
{
    //page de liste des packs
    public function listePack()
    {
        //Verfier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }

        $css = ['css/annonce/annonce-list.css'];
        $js = ['asset(\'js/bootstrap.bundle.min.js\')'];
        $contentPage = 'pages/crud/liste_pack';
        $list = null;

        try {
            $list = Pack::where('etat', 1)->get();

            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }

            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'list' => $list,
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

    //page de creation pack
    public function nouveauPack()
    {
        //Verfier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }

        $css = [];
        $js = ['js/add-matiere-premiere-quantite.js'];
        $contentPage = 'pages/crud/nouveau_pack';
        try {
            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }

            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage
            ]);
        } catch(Exception $e) {
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'error' => $e->getMessage()
            ]);
        }
    }

    //page de creation pack
    public function modifierPack(Request $request)
    {
        //Verfier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }

        $css = ['css/annonce/annonce-list.css'];
        $js = ['js/add-matiere-premiere-quantite.js'];
        $contentPage = 'pages/crud/modifier_pack';
        $listMatierePremiere = null;
        $id_pack = $request->id_pack;

        $pack = null;
        $listMatierePremiere = null;
        $listMPQtePack = null;

        try {
            $listMatierePremiere = VMatierePremiereUnite::where('etat', 1)->get();
            $pack = Pack::find($id_pack);
            $listMPQtePack = VMatierePremiereQuantite::findMPQtePack($id_pack);

            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }

            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'listMatierePremiere' => $listMatierePremiere,
                'pack' => $pack,
                'listMPQtePack' => $listMPQtePack
            ]);
        } catch(Exception $e) {
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'listMatierePremiere' => $listMatierePremiere,
                'pack' => $pack,
                'error' => $e->getMessage(),
                'listMPQtePack' => $listMPQtePack
            ]);
        }
    }

    //Mettre a jour le pack
    public function update(Request $request) {
        //Verfier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }

        try {
            
            $pack = Pack::find($request->id_pack);
            $pack->setNom($request->nom);
            $pack->setPrixUnitaire($request->prix_unitaire);
            if($request->photo != null) {
                $pack->setPhoto($request);
            } 
            if($request->description != null) {
                $pack->setDescription($request->description);
            }

            $pack->save(); 
        } catch(Exception $e) {  
            return redirect()->route('modifier_pack', (['error' => $e->getMessage(), 'id_pack' => $request->id_pack]));
        }
 
        return redirect()->route('liste_pack');
    }

    //Enregistrer pack
    public function save(Request $request)
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
        try {
            $pack = new Pack;
            $pack->setNom($request->nom);
            $pack->setPrixUnitaire($request->prix_unitaire);
            $pack->setPhoto($request);
            $pack->setDescription($request->description);
            $pack->etat = 1;
            $pack->save();

        } catch(Exception $e) {  
            return redirect()->route('nouveau_pack', (['error' => $e->getMessage()]));
        }
        return redirect()->route('nouveau_pack');
    } 

    public function addMatierePremiereQuantite(Request $request)
    {
        $id_matiere_premiere = $request->input('id_matiere_premiere');
        $quantite = $request->input('quantite');
        $id_pack = $request->input('id_pack');

        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }

        try {
            $matierePremierePack = new MatierePremierePack;
            $matierePremierePack->setMatierePremiere($id_matiere_premiere);
            $matierePremierePack->setQuantite($quantite);
            $matierePremierePack->pack_id = $id_pack;
            $matierePremierePack->save();

            return redirect()->route('modifier_pack', (['id_pack' => $id_pack]));
        } catch(Exception $e) {
            return redirect()->route('modifier_pack', (['error' => $e->getMessage(), 'id_pack' => $id_pack]));
        }
    }

    //Supprimer la matiere premiere quantite pack
    public function deleteMPQtePack(Request $request) {
        //Verfier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
        $id_pack = $request->id_pack;
        $id_matiere_premiere = $request->id_matiere_premiere;
        try {
            
            MatierePremierePack::deleteMPQtePack($id_pack, $id_matiere_premiere);
            
        } catch(Exception $e) {  
            return redirect()->route('modifier_pack', (['error' => $e->getMessage(), 'id_pack' => $id_pack]));
        }
 
        return redirect()->route('modifier_pack', (['id_pack' => $id_pack]));
    }

    //Supprimer le pack
    public function deletePack(Request $request) {
        //Verfier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
        $id_pack = $request->id_pack;
        try {
            //Log::debug('id_pack = '.$id_pack);
            //Log::debug(MatierePremierePack::find($id_pack));

            Pack::find($id_pack)->delete();
            
        } catch(Exception $e) {  
            return redirect()->route('liste_pack', (['error' => $e->getMessage()]));
        }
 
        return redirect()->route('liste_pack');
    }

    //Restaurer le pack
    public function restaurerPack(Request $request) {
        //Verfier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
        $id_pack = $request->id_pack;
        try {
           $packToRestaured = Pack::onlyTrashed()->find($id_pack);
            if($packToRestaured) {
                $packToRestaured->restore();
            } else {
                throw new Exception("Pack n'ont trouve");
            }
            Pack::find($id_pack)->restore();
            
        } catch(Exception $e) {  
            return redirect()->route('liste_pack', (['error' => $e->getMessage()]));
        }
 
        return redirect()->route('liste_pack');
    }

    //Liste des packs supprimes
    public function packListDeleted(Request $request) {
        //Verfier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
 
        $css = ['css/annonce/annonce-list.css'];
        $js = ['asset(\'js/bootstrap.bundle.min.js\')'];
        $contentPage = 'pages/crud/liste_pack';
        $list = null;
 
        try {
            $list = Pack::onlyTrashed()->get();
 
            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }
 
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'list' => $list,
                'id_helper' => 1
            ]);
        } catch(Exception $e) {
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'list' => $list,
                'error' => $e->getMessage(),
                'id_helper' => 1
            ]);
        }
    }
}
