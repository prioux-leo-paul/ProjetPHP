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
                echo  "Produit : ".$u->get("nomProduit")."\n";
                echo  "Prix : ".$u->get("prix")."\n";
                echo "Taille : ".$u->get("tailleProduit")."\n";
                echo  "Description : ".$u->get("descriptionProduit")."\n \n";
        }
        
    }

    public static function ajouterpanier(){
        if(empty($_SESSION['panier']))
            $_SESSION['panier']=array(1);
        else
            array_push($_SESSION['panier'],1);
        
        header("Location: index.php?controller=produit&action=voirpanier");
    }

    public static function voirpanier(){
        $controller = "produits";
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
