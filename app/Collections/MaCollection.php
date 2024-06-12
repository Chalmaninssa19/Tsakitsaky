<?php 
namespace App\Collections;

class MaCollection {
    private $elements = array();

    public function ajouter($objet) {
        $this->elements[] = $objet;
    }

    public function supprimer($index) {
        unset($this->elements[$index]);
        // Réindexer les éléments si nécessaire
        $this->elements = array_values($this->elements);
    }

    public function lister() {
        return $this->elements;
    }
}
