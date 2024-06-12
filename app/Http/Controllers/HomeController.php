<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //Page d'accueil
    //Authentification d'un utilisateur
    public function home()
    {
        $profilconnected = session()->get('authentified');
        if(!isset($profilconnected)) {
            return redirect()->route('pageLogin');
        }
        
        $css = ['asset(\'css/supplier/supplier.css\')'];
        $js = [];
        $contentPage = 'pages/home/home';
    
        return view('pages/template')->with([
            'css' => $css,
            'js' => $js,
            'contentPage' => $contentPage
        ]);
    }
}
