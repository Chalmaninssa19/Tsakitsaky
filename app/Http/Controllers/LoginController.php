<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\authentification\Utilisateur;
use App\Models\authentification\Authentified;
use Exception;

class LoginController extends Controller
{
    public function index()
    {
        
        return view('pages/auth/login');
    }

    //Authentification d'un utilisateur
    public function authenticate(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'username' => 'required|string',
                'mdp' => 'required|string',
            ], [
                'required' => 'Le champ :attribute est obligatoire.',
                'string' => 'Le champ :attribute doit être une chaîne de caractères.',
            ]);
            

            // Créer un nouvel utilisateur avec les données validées
            $utilisateur = Utilisateur::authenticate($validatedData['username'], $validatedData['mdp']);
            $authentified = new Authentified($utilisateur->profil, true);
            session()->put('authentified', $authentified);

            return redirect()->route('tableau_bord');

        } catch(Exception $e) {  
            return view('pages/auth/login')->with('error', $e->getMessage());
        }
    }

    //Se deconnecter
    public function deconnect(Request $request) {
        $request->session()->flush();
        /*$profilSource = session()->get('profilConnected');

        // Récupérez l'ID de session actuel
        $sessionId = session()->getId();

        // Utilisez l'ID de session pour oublier la session
        Session::forget($sessionId);
*/
    return redirect()->route('pageLogin');
}
}
