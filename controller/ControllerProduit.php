<?php

require_once File::buildpath(array("model","ModelProduits.php"));

class ControllerProduit {
    
    
    public static function read(){
        $prod =$_GET['numpro'];
        $product = ModelProduits::selectPrimary($prod);
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

    public static function allproduit(){
        $controller = "produits";
        $view = "filtre";
        $pagetile = "Produits";
        require (File::buildpath(array("view","view.php")));
        $tab = ModelProduits::selectAll();
        foreach($tab as $u){
                echo  "Produit : ".$u["nomProduit"]."\n";
                echo  "Prix : ".$u["prixProduit"]."\n";
                echo "Taille : ".$u["tailleProduit"]."\n";
                echo  "Description : ".$u["descriptionProduit"]."\n \n";
        }
        
    }
}




?>
