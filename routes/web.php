<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MatierePremiereController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\BilletController;
use App\Http\Controllers\UniteController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\AxeLivraisonController;
use App\Http\Controllers\StatistiqueController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::GET('/', [LoginController::class, 'index'])
->name('pageLogin');

Route::POST('/login', [LoginController::class, 'authenticate'])
->name('login');

Route::GET('/deconnect', [LoginController::class, 'deconnect'])
->name('deconnect');

Route::GET('/unite', [UniteController::class, 'listUnite'])
->name('unite');

Route::POST('/save_unite', [UniteController::class, 'save'])
->name('save_unite');

Route::GET('/delete_unite', [UniteController::class, 'delete'])
->name('delete_unite');

Route::GET('/matiere_premiere', [MatierePremiereController::class, 'listMatierePremiere'])
->name('matiere_premiere');

Route::GET('/delete_matiere_premiere', [MatierePremiereController::class, 'delete'])
->name('delete_matiere_premiere');

Route::POST('/save_matiere_premiere', [MatierePremiereController::class, 'save'])
->name('save_matiere_premiere');

Route::GET('/edit_matiere_premiere', [MatierePremiereController::class, 'edit'])
->name('edit_matiere_premiere');

Route::POST('/tri-matiere-premiere-list', [MatierePremiereController::class, 'tri'])
->name('tri-matiere-premiere-list');

Route::POST('/update_matiere_premiere', [MatierePremiereController::class, 'update'])
->name('update_matiere_premiere');

Route::GET('/etudiant', [EtudiantController::class, 'listEtudiant'])
->name('etudiant');

Route::POST('/save_etudiant', [EtudiantController::class, 'save'])
->name('save_etudiant');

Route::GET('/delete_etudiant', [EtudiantController::class, 'delete'])
->name('delete_etudiant');

Route::GET('/edit_etudiant', [EtudiantController::class, 'edit'])
->name('edit_etudiant');

Route::POSt('/update_etudiant', [EtudiantController::class, 'update'])
->name('update_etudiant');

Route::GET('/liste_pack', [PackController::class, 'listePack'])
->name('liste_pack');

Route::GET('/nouveau_pack', [PackController::class, 'nouveauPack'])
->name('nouveau_pack');

Route::POST('/save_pack', [PackController::class, 'save'])
->name('save_pack');

Route::POST('/update_pack', [PackController::class, 'update'])
->name('update_pack');

Route::POSt('/add-matiere-premiere-quantite', [PackController::class, 'addMatierePremiereQuantite'])
->name('add-matiere-premiere-quantite');

Route::GET('/delete-mpqte-pack', [PackController::class, 'deleteMPQtePack'])
->name('delete-mpqte-pack');

Route::GET('/modifier_pack', [PackController::class, 'modifierPack'])
->name('modifier_pack');

Route::GET('/delete_pack', [PackController::class, 'deletePack'])
->name('delete_pack');

Route::GET('/liste_deleted_pack', [PackController::class, 'packListDeleted'])
->name('liste_deleted_pack');

Route::GET('/restaurer_pack', [PackController::class, 'restaurerPack'])
->name('restaurer_pack');

Route::GET('/vendre_billet1', [BilletController::class, 'vendreBillet1'])
->name('vendre_billet1');

Route::GET('/vendre_billet', [BilletController::class, 'vendreBillet'])
->name('vendre_billet');

Route::POST('/save_vente_billet1', [BilletController::class, 'save1'])
->name('save_vente_billet1');

Route::POST('/save_vente_billet', [BilletController::class, 'save'])
->name('save_vente_billet');

Route::GET('/etat_vente', [BilletController::class, 'etatVente'])
->name('etat_vente');

Route::GET('/detail_vente_etudiant', [BilletController::class, 'detailVenteEtudiant'])
->name('detail_vente_etudiant');

Route::POST('/payer_billet', [BilletController::class, 'payerBillet'])
->name('payer_billet');

Route::GET('/paiement_billet_etudiant', [BilletController::class, 'paiementEtudiant'])
->name('paiement_billet_etudiant');

Route::GET('/historique_paiement_etudiant', [BilletController::class, 'historiquePaiementEtudiant'])
->name('historique_paiement_etudiant');

Route::GET('/axe_livraison', [AxeLivraisonController::class, 'listAxeLivraison'])
->name('axe_livraison');

Route::POST('/save_axe_livraison', [AxeLivraisonController::class, 'save'])
->name('save_axe_livraison');

Route::GET('/delete_axe_livraison', [AxeLivraisonController::class, 'delete'])
->name('delete_axe_livraison');

Route::GET('/livraison', [BilletController::class, 'livraison'])
->name('livraison');

Route::GET('/detail_livraison', [BilletController::class, 'detailLivraison'])
->name('detail_livraison');

Route::GET('/export_livraison_pdf', [BilletController::class, 'exportLivraisonPdf'])
->name('export_livraison_pdf');

Route::GET('/export_excel_vente_pack', [BilletController::class, 'exportExcelVentePack'])
->name('export_excel_vente_pack');

Route::GET('/tableau_bord', [StatistiqueController::class, 'tableauBord'])
->name('tableau_bord');

Route::GET('/graphe_camembert', [StatistiqueController::class, 'grapheCamembert'])
->name('graphe_camembert');

Route::GET('/page_import_vente', [BilletController::class, 'pageImportVente'])
->name('page_import_vente');

Route::POST('/import_vente_billet', [BilletController::class, 'importVenteBillet'])
->name('import_vente_billet');