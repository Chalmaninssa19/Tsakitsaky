<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\crud\Pack;
use App\Models\crud\Etudiant;
use App\Models\crud\AxeLivraison;
use App\Models\gestion_billet\VenteBillet;
use App\Models\gestion_billet\PaiementBillet;
use App\Models\gestion_billet\VEtatVenteEtudiant;
use App\Models\gestion_billet\VBilletVenduEtudiant;
use App\Models\gestion_billet\VLivraisonAxe;
use App\Models\gestion_billet\VEtatPaiement;
use App\Models\gestion_billet\ImportVenteBillet;
use Illuminate\Support\Facades\Log;
use Exception;
use Dompdf\Dompdf;
use App\Exports\VVentePackExport;
use Maatwebsite\Excel\Facades\Excel;

class BilletController extends Controller
{
     //page d'insertion de vente billet 1
     public function vendreBillet1()
     {
         //Verfier l'authentification
         $profilconnected = session()->get('authentified');
         if(!isset($profilconnected)) {
             return redirect()->route('pageLogin');
         }
  
         $css = [];
         $js = ['assets(\'js/bootstrap.bundle.min.js\')'];
         $contentPage = 'pages/gestion_billet/vendre_billet1';
         $listAxe = null;
 
         try {
             $listAxe = AxeLivraison::where('etat', 1)->get();
 
             if(isset($_GET['error'])) {
                 throw new Exception($_GET['error']);
             }
 
             return view('pages/template')->with([
                 'css' => $css,
                 'js' => $js,
                 'contentPage' => $contentPage,
                 'listAxe' => $listAxe
             ]);
         } catch(Exception $e) {
             return view('pages/template')->with([
                 'css' => $css,
                 'js' => $js,
                 'contentPage' => $contentPage,
                 'listAxe' => $listAxe,
                 'error' => $e->getMessage()
             ]);
         }   
     }

     
    //page d'insertion de vente billet
    public function vendreBillet()
    {
        //Verfier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
 
        $css = [];
        $js = ['assets(\'js/bootstrap.bundle.min.js\')'];
        $contentPage = 'pages/gestion_billet/vendre_billet';
        $listEtudiant = null;
        $listPack = null;

        try {
            $listEtudiant = Etudiant::where('etat', 1)->get();
            $listPack = Pack::where('etat', 1)->get();

            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }

            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'listEtudiant' => $listEtudiant,
                'listPack' => $listPack
            ]);
        } catch(Exception $e) {
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'listEtudiant' => $listEtudiant,
                'listPack' => $listPack,
                'error' => $e->getMessage()
            ]);
        }   
    }

    //Enregistrer une vente information client
    public function save1(Request $request)
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
        try {
            $venteBillet = new VenteBillet;
            $venteBillet->setNomClient($request->input('nom_client'));
            $venteBillet->setContactClient($request->input('contact_client'));
            $venteBillet->setAxeLivraison($request->input('axe_livraison'));
            $venteBillet->etat = 1;

            session()->put('venteBillet', $venteBillet);

        } catch(Exception $e) {  
            return redirect()->route('vendre_billet1', (['error' => $e->getMessage()]));
        }
        return redirect()->route('vendre_billet');
    } 

    //Enregistrer une vente
    public function save(Request $request)
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        $venteBillet = session()->get('venteBillet');

        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
        if(!isset($venteBillet)) {
            throw new Exception('Impossible d\'effectuer cette operation : vous devrez enregistrer 
            en premier les informations du client, veuillez vous rendre dans le menu vendre billet');
        }
        try {
            $venteBillet->setDate($request->input('date_vente'));
            $venteBillet->setQuantite($request->input('quantite'));
            $venteBillet->setEtudiant($request->input('etudiant'));
            $venteBillet->setBillet($request->input('billet_vendu'));
            $venteBillet->etat = 1;

            $venteBillet->save();
        } catch(Exception $e) {  
            return redirect()->route('vendre_billet', (['error' => $e->getMessage()]));
        }
        return redirect()->route('vendre_billet1', (['success' => 'Insertion vente reussi']));
    } 
    //page d'etat de vente billets'
    public function etatVente()
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }

        $css = [];
        $js = ['assets(\'js/bootstrap.bundle.min.js\')'];
        $contentPage = 'pages/gestion_billet/etat_vente';
    
        $etatVente = null;
        $totalMontantMpNecessaire = 0;

        try {

            $etatVente = VEtatVenteEtudiant::all();
            $totalMontantMpNecessaire = VEtatVenteEtudiant::totalMontantMpNecessaire();

            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }

            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'etatVente' => $etatVente,
                'totalMontantMpNecessaire' => $totalMontantMpNecessaire
            ]);
        } catch(Exception $e) {
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'etatVente' => $etatVente,
                'error' => $e->getMessage(),
                'totalMontantMpNecessaire' => $totalMontantMpNecessaire
            ]);
        } 
    }

    //page de details vente par etudiant'
    public function detailVenteEtudiant(Request $request)
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }

        $css = ['css/billet/detail_vente_etudiant.css'];
        $js = ['asset(\'js/bootstrap.bundle.min.js\')'];
        $contentPage = 'pages/gestion_billet/detail_vente_etudiant';
        $id_etudiant = $request->id_etudiant;
        $etudiant =null;
        $etatVente = null;
        $benefice = 0;
        $billetVenduEtudiant = null;
    
        try {
            $etudiant = Etudiant::find($id_etudiant);
            $etatVente = VEtatVenteEtudiant::where('id_etudiant', $id_etudiant)->first();
            $benefice = $etatVente->montant_billet - $etatVente->montant_mp_necessaire;
            $billetVenduEtudiant = VBilletVenduEtudiant::where('id_etudiant', $id_etudiant)->get();

            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }

            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'etudiant' => $etudiant,
                'etatVente' => $etatVente,
                'benefice' => $benefice,
                'billetVenduEtudiant' => $billetVenduEtudiant
            ]);

        } catch(Exception $e) {
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'etudiant' => $etudiant,
                'etatVente' => $etatVente,
                'benefice' => $benefice,
                'error' => $e->getMessage(),
                'billetVenduEtudiant' => $billetVenduEtudiant
            ]);
        }
    }

    //Payer les billets vendu par un etudiant
    public function payerBillet(Request $request)
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
  
        $css = ['css/billet/detail_vente_etudiant.css'];
        $js = ['asset(\'js/bootstrap.bundle.min.js\')'];
        $contentPage = 'pages/gestion_billet/paiement_billet_etudiant';
        $id_etudiant = $request->input('id_etudiant');
        $montant_payer = $request->input('montant_payer');
        $date_paiement = $request->input('date_paiement');
     
        try {
            $paiementBillet = new PaiementBillet;
            $paiementBillet->setMontantPayer($montant_payer, $id_etudiant);
            $paiementBillet->setDatePaiement($date_paiement);
            $paiementBillet->setEtudiant($id_etudiant);
            $paiementBillet->etat = 1;
            $paiementBillet->save();

            return redirect()->route('detail_vente_etudiant', (['id_etudiant' => $id_etudiant]));
        } catch(Exception $e) {
            return redirect()->route('detail_vente_etudiant', (['error' => $e->getMessage(), 'id_etudiant' => $id_etudiant]));
        }
    }

    //page de paiement par etudiant'
    public function paiementEtudiant()
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }

        $css = ['css/billet/detail_vente_etudiant.css'];
        $js = ['asset(\'js/bootstrap.bundle.min.js\')'];
        $contentPage = 'pages/gestion_billet/paiement_billet_etudiant';
        $listPaiementEtudiant = null;
        $totalEtatPaiement = null;
     
        try {
            $listPaiementEtudiant = VEtatPaiement::all();
            $totalEtatPaiement = VEtatPaiement::totalEtatPaiement();

            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }

            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'listPaiementEtudiant' => $listPaiementEtudiant,
                'totalEtatPaiement' => $totalEtatPaiement
            ]);
        } catch(Exception $e) {
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'listPaiementEtudiant' => $listPaiementEtudiant,
                'error' => $e->getMessage(),
                'totalEtatPaiement' => $totalEtatPaiement
            ]);
        }
    }

    //page d'etat des listes de livraison'
    public function livraison()
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }

        $css = [];
        $js = ['assets(\'js/bootstrap.bundle.min.js\')'];
        $contentPage = 'pages/gestion_billet/livraison';
        $listLivraison = null;
        try {

            $listLivraison = VLivraisonAxe::all();

            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }

            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'listLivraison' => $listLivraison
            ]);
        } catch(Exception $e) {
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'error' => $e->getMessage(),
                'listLivraison' => $listLivraison
            ]);
        } 
    }

//page detail livraison'
    public function detailLivraison(Request $request)
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }

        $css = [];
        $js = ['assets(\'js/bootstrap.bundle.min.js\')'];
        $contentPage = 'pages/gestion_billet/detail_livraison';
        $id_axe_livraison =$request->id_axe_livraison;

        $listLivraison = array();
        $infoAxe = null;

        try {

            $listLivraison = VLivraisonAxe::getDetailLivraisonAxe($id_axe_livraison);

            $infoAxe = VLivraisonAxe::getLivraisonAxe($id_axe_livraison);

            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }
          
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'listLivraison' => $listLivraison,
                'infoAxe' => $infoAxe
            ]);
        } catch(Exception $e) {
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'error' => $e->getMessage(),
                'listLivraison' => $listLivraison,
                'infoAxe' => $infoAxe
            ]);
        } 
    }

    //Exporter l'etat de livraison en pdf
    public function exportLivraisonPdf(Request $request) {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }

        $css = [];
        $js = ['assets(\'js/bootstrap.bundle.min.js\')'];
        $contentPage = 'pages/gestion_billet/detail_livraison';
        $id_axe_livraison =$request->id_axe_livraison;
        $listLivraison = array();
        $infoAxe = null;

        try {

            $listLivraison = VLivraisonAxe::getDetailLivraisonAxe($id_axe_livraison);
            $infoAxe = VLivraisonAxe::getLivraisonAxe($id_axe_livraison);

            $data = [
                'listLivraison' => $listLivraison,
                'infoAxe' => $infoAxe
            ];

            $pdf = new DomPdf();
            $pdf->loadHtml(view('pages/gestion_billet/vue_livraison_pdf', $data));
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();

            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }
          
            return $pdf->stream('livraison_'.$infoAxe->nom_axe.'.pdf');
        } catch(Exception $e) {
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'error' => $e->getMessage(),
                'listLivraison' => $listLivraison,
                'infoAxe' => $infoAxe
            ]);
        } 
    }

    public function exportExcelVentePack() {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
 
        $css = [];
        $js = ['assets(\'js/bootstrap.bundle.min.js\')'];
        $contentPage = 'pages/gestion_billet/etat_vente';

        try {
            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }

            return Excel::download(new VVentePackExport, 'vente_pack.xlsx');
        } catch(Exception $e) {
            return redirect()->route('etat_vente', (['error' => $e->getMessage()]));
        }
    }
    //page historique de paiement par etudiant'
     public function historiquePaiementEtudiant()
     {
         $css = ['css/billet/detail_vente_etudiant.css'];
         $js = ['asset(\'js/bootstrap.bundle.min.js\')'];
         $contentPage = 'pages/gestion_billet/historique_paiement';
      
         return view('pages/template')->with([
             'css' => $css,
             'js' => $js,
             'contentPage' => $contentPage
         ]);
     }

    //page d'importation vente billet
    public function pageImportVente()
    {
        //Verifier l'authentification
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }

        $css = ['css/billet/detail_vente_etudiant.css'];
        $js = ['asset(\'js/bootstrap.bundle.min.js\')'];
        $contentPage = 'pages/gestion_billet/page_import_vente';
        $success = null;
       
        try {
            if(isset($_GET['error'])) {
                throw new Exception($_GET['error']);
            }
            if(isset($_GET['success'])) {
                $success = $_GET['success'];
            }
            return view('pages/template')->with([
                'css' => $css,
                'js' => $js,
                'contentPage' => $contentPage,
                'success' => $success
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

    //Importation csv
    public function importVenteBillet(Request $request)
    {
            //Verifier l'authentification
            $profilconnected = session()->get('authentified');
            if(!isset($profilconnected)) {
                return redirect()->route('pageLogin');
            }
        try {
            Log::debug('Tafiditra');
            $request->validate([
                'import_csv' => 'required',
            ], [
                'required' => 'Le champ est vide',
                'mimes:csv' => 'Doit etre au format csv'
            ]);
            Log::debug('Tonga any');
            //read csv file and skip data
            $file = $request->file('import_csv');
            $handle = fopen($file->path(), 'r');

            //skip the header row
            fgetcsv($handle);
    
            $chunksize = 25;
            while(!feof($handle))
            {
                $chunkdata = [];
    
                for($i = 0; $i<$chunksize; $i++)
                {
                    $data = fgetcsv($handle);
                    if($data === false)
                    {
                        break;
                    }
                    $chunkdata[] = $data; 
                }
    
                ImportVenteBillet::valideData($chunkdata);
            }
            fclose($handle);
    
            return redirect()->route('page_import_vente', (['success' => 'Les donnees ont ete bien enregistres']));
        } catch(Exception $e) {
            return redirect()->route('page_import_vente', (['error' => $e->getMessage()]));
        }
    }
}
