<?php

require_once File::buildpath(array("model","ModelProduits.php"));

class ControllerProduit {
    
    public static function Afficherproduit(){
        $controller = "produit";
        $view = "Test";
        $pagetile = "Page de test";
        $tab = ModelProduit::selectAll();
        require File::buildpath(array("view","view.php"));
    }
    
}




?>
