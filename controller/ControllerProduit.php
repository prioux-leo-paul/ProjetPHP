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
    public static function read(){
        $prod =$_GET['numpro'];
        $product = ModelProduit::selectPrimary($prod);
        if($product){
            $controller = "produit";
            $view = "Test";
            $pagetile = "Page de test";
            require(File::buildpath(array("view","view.php")));
        }
        else{
            $controller = "membre";
            $view = "Error";
            $pagetile = "Page d'erreur";
            require(File::buildpath(array("view","view.php")));
        }
    }
}




?>
