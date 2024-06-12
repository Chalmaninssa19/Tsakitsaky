<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\gestion_billet\VVentePack;
use App\Models\gestion_billet\VEtatVenteEtudiant;

class StatistiqueController extends Controller
{
    //Tableau de bord
    public function tableauBord() {
        //Verfier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
 
        $css = [];
        $js = ['vendors/chart.js/Chart.min.js', 'js/statistiques/graphe.js'];
        $contentPage = 'pages/statistiques/tableauBord';
        $totalEtatVente = null;
       
        try {
          
            $totalEtatVente = VEtatVenteEtudiant::totalEtatVente();

            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }
       
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'totalEtatVente' => $totalEtatVente
            ]);
        } catch(Exception $e) {
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'error' => $e->getMessage(),
                'totalEtatVente' => $totalEtatVente
            ]);
        }  
    }

    //Graphe de camembert
    public function grapheCamembert() {
        //Verfier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
 
        try {
            $vente_pack = VVentePack::all();
            $dataCourbe = ["2013", "2014", "2014", "2015", "2016", "2017", "2018", "2019", "2020"];
            $labelCourbe = [23590, 130000, 10002, 249000, 10000, 239400, 123000, 135900, 465201];
            $data = [];
            $label = [];
            foreach($vente_pack as $item) {
                $data [] = $item->montant;
                $label [] = $item->nom;
            }
            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }            

            return response()->json(['data' => $data, 
                    'label' => $label,
                    'dataCourbe' => $dataCourbe,
                    'labelCourbe' => $labelCourbe
                ]);
         } catch(Exception $e) {
            throw $e;
         }  
    }

    //Graphe de courbe
     public function grapheCourbe() {
        //Verfier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
 
        try {
            $vente_pack = VVentePack::all();

            $data = [];
            $label = [];
            foreach($vente_pack as $item) {
                $data [] = $item->montant;
                $label [] = $item->nom;
            }
            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }            

            return response()->json(['data' => $data, 'label' => $label]);
         } catch(Exception $e) {
            throw $e;
         }  
    }
}
