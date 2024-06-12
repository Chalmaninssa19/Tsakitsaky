<?php

namespace App\Models\authentification;


class Authentified
{
    private $profil;
    private $isAuthentified;

///Constructors
    public function __construct($profil, $isAuthentified)
    {
        $this->profil = $profil;
        $this->isAuthentified = $isAuthentified;
    }

///Encapsulation
    public function getProfil()
    {
        return $this->profil;
    }
    public function setProfil($value)
    {
        $this->profil = $value;
    }
    public function getIsAuthentified()
    {
        return $this->isAuthentified;
    }
    public function setIsAuthentified($value)
    {
        $this->isAuthentified = $value;
    }

///Fonctions
   
}
