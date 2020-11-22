<?php

require_once File::buildpath(array("model","ModelProduits.php"));
require_once File::buildpath(array("model","ModelCategories.php"));

class ControllerProduit {
    protected static $object = "produits";
    
    public static function read(){
        $prod =$_GET['numpro'];
        $product = ModelProduits::selectPrimary($prod);
        if($product){
            $view = "Test";
            $pagetile = "Page de test";
            require(File::buildpath(array("view","view.php")));
        }
        else{
            $view = "Error";
            $pagetile = "Page d'erreur";
            require(File::buildpath(array("view","view.php")));
        }
    }

    public static function allproduit(){
        $view = "filtre";
        $pagetile = "Produits";
        require (File::buildpath(array("view","view.php")));
        $tab = ModelProduits::selectAll();
        foreach($tab as $u){
                echo  "Produit : ".$u->get("nomProduit")."\n";
                echo  "Prix : ".$u->get("prix")."\n";
                echo "Taille : ".$u->get("tailleProduit")."\n";
                echo  "Description : ".$u->get("descriptionProduit")."\n \n";
        }
        
    }

    public static function showproduct($param){
        $current_product = ModelProduits::selectPrimary($param);
        $current_numcategory = $current_product->get("numCategorie");
        $current_category = ModelCategories::selectPrimary($current_numcategory);
        $view = "produitgenerique";
        $pagetile = $current_product->get("nomProduit");
        require (File::buildpath(array("view","view.php")));
    }

    public static function ajouterpanier($produit,$taille){
        $produit->set("taille",$taille);

        if(empty($_SESSION['panier']))
            $_SESSION['panier']=array($produit);
        else
            array_push($_SESSION['panier'],$produit);
        
        
    }

    public static function voirpanier(){
        $view = "panier";
        $pagetile = "Panier";
        require (File::buildpath(array("view","view.php")));
        if(!empty($_SESSION['panier'])){
            $array = $_SESSION['panier'];
            $tab = ModelProduits::selectAll();
            foreach($tab as $u){
                foreach($array as $i){
                    if($u->get("numProduit") == $i){
                        echo  "Produit : ".$u->get("nomProduit")."\n";
                        echo  "Prix : ".$u->get("prix")."\n";
                        echo "Taille : ".$u->get("tailleProduit")."\n";
                        echo  "Description : ".$u->get("descriptionProduit")."\n \n";
                    }
                }
            }
        }
        else 
            echo "Votre panier est vide";
    }
}




?>
