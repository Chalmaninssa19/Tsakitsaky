<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Models\Profile;
use App\Models\EmailEnvoye;
use App\Models\EmailRecu;
use App\Models\Util;
use Illuminate\Support\Facades\Session;

class EmailController extends Controller
{
    //Page de login
    public function getPageLogin()
    {
        
        return view('pages/login');
    }

    //Se connecter
    public function login()
    {
        try {
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];
            $profil = Profile::login($mdp, $email);
            if($profil != null) {
                session()->put('profilConnected', $profil);
                return redirect()->route('boiteReception');
            }
            else {
                throw new Exception("Veuillez ressayer");
            }

        } catch(Exception $e) {
            return view('pages/login')->with('error', $e->getMessage());
        }
    }

    //Avoir la boite de reception
    public function getBoiteReception()
    {
        $error = null;
        $boiteReception = null;
        
        /*try {
            $error = null;
            if(isset($_GET['error'])) {
                $error = $_GET['error'];
            }
        
            $profilconnected = session()->get('profilConnected');
            $boiteReception = EmailRecu::getBoiteReception($profilconnected);
        } catch(Exception $e) {
            $profilconnected = session()->get('profilConnected');
            $boiteReception = EmailRecu::getBoiteReception($profilconnected);
            return view('pages/boiteReception')->with([
                'error' => $error.' '.$e->getMessage(),
                'boiteReception' => $boiteReception
            ]);
        }*/
        return view('pages/boiteReception')->with([
            'error' => $error,
            'boiteReception' => $boiteReception
        ]);
    }

    //Recuperer les details d'une boite de reception
    public function getDetailsReception()
    {
        try {
            $error = null;
            if(isset($_GET['error'])) {
                $error = $_GET['error'];
            }
                
            $idEmailRecu = $_GET['idEmailRecu'];
            $emailRecu = EmailRecu::findById($idEmailRecu);
            if($emailRecu->getEtat()  != 2) {
                $emailRecu->lireEmail();
            }

        } catch(Exception $e) {
            return redirect()->route('boiteReception', (['error' => $error.' '.$e->getMessage()]));
        }
        return view('pages/detailsReception')->with([
            'error' => $error,
            'emailRecu' => $emailRecu
        ]);
    }

    //Repondre une email
    public function repondreEmail() {
        try {
            $error = null;
            if(isset($_GET['error'])) {
                $error = $_GET['error'];
            }
                
            $idEmailRecu = $_POST['idEmailRecu'];
            $text = $_POST['reponse'];
            $emailRecu = EmailRecu::findById($idEmailRecu);
            $emailenvoi = new EmailEnvoye('DEFAULT', $emailRecu->getProfileSource(), $emailRecu->getProfileDestinataire(), $emailRecu->getSujet(), $text);
                        
            $newEmailRecu = new EmailRecu('DEFAULT', $emailRecu->getProfileSource(), $emailRecu->getProfileDestinataire(), $emailRecu->getSujet(), $text, 1, 0);
            $emailenvoi->sendingEmail($newEmailRecu);

        } catch(Exception $e) {
           
            return view('pages/boiteReception')->with([
                'error' => $error.' '.$e->getMessage(),
                'emailRecu' => $emailRecu
            ]);
        }
        return view('pages/detailsReception')->with([
            'error' => $error,
            'emailRecu' => $emailRecu
        ]);
    }

    //Avoir les emails envoyes
    public function getEnvoye()
    {
        try {
            $error = null;
            if(isset($_GET['error'])) {
                $error = $_GET['error'];
            }

            $profilconnected = session()->get('profilConnected');
            $emailEnvoye = EmailEnvoye::getEmailEnvoye($profilconnected);

        } catch(Exception $e) {
            $profilconnected = session()->get('profilConnected');
            $emailEnvoye = EmailEnvoye::getEmailEnvoye($profilconnected);

            return view('pages/envoye')->with([
                'error' =>$error.' '.$e->getMessage(),
                'emailEnvoye' => $emailEnvoye
            ]);
        } 
        return view('pages/envoye')->with([
            'error' =>$error,
            'emailEnvoye' => $emailEnvoye
        ]);
    }

    public function getNewMessage()
    {
        $profilConnected = session()->get('profilConnected');
        $profile = Profile::getProfileToSend($profilConnected); 
        $error = null;
        if(isset($_GET['error'])) {
            $error = $_GET['error'];
        }

        return view('pages/newMessage')->with([
            'error' => $error,
            'profile' => $profile
        ]);
    }

    //Envoyer un nouveau message
    public function sendMessage()
    {
        try {
            $profile = $_POST['profile'];
            $sujet = $_POST['sujet'];
            $text = $_POST['text'];
            $profileDestination = Profile::findById($profile);
            $profilSource = session()->get('profilConnected');

            $isSpam = EmailEnvoye::isEmailSpam($sujet);

            $emailEnvoye = new EmailEnvoye('DEFAULT', $profileDestination, $profilSource, $sujet, $text);
            $emailRecu = new EmailRecu('DEFAULT', $profileDestination, $profilSource, $sujet, $text, 1, $isSpam);
            $emailEnvoye->sendingEmail($emailRecu); 
        } catch(Exception $e) {
            return redirect()->route('newMessage', (['error' => $e->getMessage()]));
        }
        
        return redirect()->route('newMessage');
    }

    //Se deconnecter
    public function deconnect() {
        // Récupérez l'ID de session actuel
        $sessionId = session()->getId();

        // Utilisez l'ID de session pour oublier la session
        Session::forget($sessionId);

        return view('pages/login');
    }

    //Avoir les informations du profil connecte
    public function getProfileConnected() {
        try {
            $error = null;
            if(isset($_GET['error'])) {
                $error = $_GET['error'];
            }
            $profilConnected = session()->get('profilConnected');

        } catch(Exception $e) {
            return view('pages/profile')->with([
                'error' => $error.' '.$e->getMessage(),
                'profileConnected' => $profilConnected
            ]);
        }
        return view('pages/profile')->with([
            'error' => $error,
            'profileConnected' => $profilConnected
        ]);
    }

    //Avoir les details d'un envoi
    public function getDetailsEnvoi() {
        try {
            $error = null;
            if(isset($_GET['error'])) {
                $error = $_GET['error'];
            }
                
            $idEmailEnvoi = $_GET['idEmailEnvoye'];
            $emailEnvoi = EmailEnvoye::findById($idEmailEnvoi);

        } catch(Exception $e) {
            return redirect()->route('envoye', (['error' => $error.' '.$e->getMessage()]));
        }
        return view('pages/detailsEnvoi')->with([
            'error' => $error,
            'emailEnvoi' => $emailEnvoi
        ]);
    }

    //Recuperer les emails spam
    public function getSpam() {
        try {
            $error = null;
            if(isset($_GET['error'])) {
                $error = $_GET['error'];
            }

            $profilconnected = session()->get('profilConnected');
            $emailSpam = EmailRecu::getEmailSpam($profilconnected);

        } catch(Exception $e) {
            $profilconnected = session()->get('profilConnected');
            $emailSpam = EmailRecu::getEmailSpam($profilconnected);

            return view('pages/spam')->with([
                'error' =>$error.' '.$e->getMessage(),
                'emailSpam' => $emailSpam
            ]);
        } 
        return view('pages/spam')->with([
            'error' =>$error,
            'emailSpam' => $emailSpam
        ]);
    }

    //Signaler un email recu comme spam
    public function signaleSpam() {
        try {
            $error = null;
            if(isset($_GET['error'])) {
                $error = $_GET['error'];
            }
                
            $idEmailRecu = $_GET['idEmailRecu'];
            $emailRecu = EmailRecu::findById($idEmailRecu);
            $emailRecu->setEmailSpam();

        } catch(Exception $e) {
            return redirect()->route('boiteReception', (['error' => $error.' '.$e->getMessage()]));
        }
        return redirect()->back();
    }

    //Signaler un email recu comme non spam
    public function signaleNoSpam() {
        try {
            $error = null;
            if(isset($_GET['error'])) {
                $error = $_GET['error'];
            }
                
            $idEmailRecu = $_GET['idEmailRecu'];
            $emailRecu = EmailRecu::findById($idEmailRecu);
            $emailRecu->setEmailNoSpam();

        } catch(Exception $e) {
            return redirect()->route('spam', (['error' => $error.' '.$e->getMessage()]));
        }
        return redirect()->back();
    }

    public function getUpdate() {
        try {
            $error = null;
            if(isset($_GET['error'])) {
                $error = $_GET['error'];
            }

            $nbNewDatas = EmailRecu::getNbNewDatas();
        } catch(Exception $e) {
            $nbNewDatas = EmailRecu::getNbNewDatas();
            return view('pages/update')->with([
                'error' =>$error.' '.$e->getMessage(),
                'nbNewDatas' => $nbNewDatas
            ]);
        }
        return view('pages/update')->with([
            'error' =>$error,
            'nbNewDatas' => $nbNewDatas
        ]);
    }

    public function update() {
        try {
            $update = EmailEnvoye::updateModele();
            echo $update;
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }


     //Afficher la vue du test correction
     public function testCorrection() {
        // Exemple d'utilisation
        $plaintext = "Hello, world!";
        $encryptionKey = "00112233445566778899AABBCCDDEEFF"; // Assurez-vous d'utiliser une clé sécurisée et unique

        $encrypted = Util::encryptAES($plaintext, $encryptionKey);
        echo "Texte chiffré : " . $encrypted . "\n";

        $decrypted = Util::decryptAES($encrypted, $encryptionKey);
        echo "Texte déchiffré : " . $decrypted . "\n";


        return view('pages/testCorrection');
    }

    public function getSuggestions(Request $request)
    {
        /*$word1 = "chat";
        $word2 = "chien";

        $levenshteinDistance = Util::levenshteinDistance($word1, $word2);
        $damerauLevenshteinDistance = Util::damerauLevenshteinDistance($word1, $word2);

        // Affichage des résultats
        echo "Distance de Levenshtein entre $word1 et $word2 : $levenshteinDistance";
        echo "Distance de Damerau-Levenshtein entre $word1 et $word2 : $damerauLevenshteinDistance";*/
        //$inputWord = "bonjowr";
        $inputWord = $request->input('word');
        $similarWords = Util::findSimilarWords($inputWord);
        $motProposes = [];

        foreach ($similarWords as $word) {
            $motProposes[] = $word['word'];
        }

        return response()->json($motProposes);
    }
}
?>