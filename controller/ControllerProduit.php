<?php

require_once File::buildpath(array("model","ModelProduits.php"));
require_once File::buildpath(array("model","ModelCategories.php"));
require_once File::buildpath(array("model","ModelTailles.php"));
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
        echo "<div class =\"divProduit\">";
        foreach($tab as $u){
                echo "<div class =\"containerProduit\">";
                echo "<img src=\"" . $u->get("imgPath"). "\">";
                echo "<div class=\"nomProduit\">" . $u->get("nomProduit") . "</div>";
                echo "<div class=\"descriptionProduit\">" . $u->get("descriptionProduit") . "</div>";
                echo "<div class=\"prixProduit\">" . $u->get("prix") . " EUR</div>";
                echo "</div>";
        }
        echo "</div>";
        
    }

    

    public static function voirpanier(){
        $view = "panier";
        $pagetile = "Panier";
        require (File::buildpath(array("view","view.php")));
        if(!empty($_SESSION['panier'])){
            $array = $_SESSION['panier'];
            //$tab = ModelProduits::selectAll();
                for($i = 0; $i < count($array); $i++){
                    
                        echo  "Produit : ".$array[$i]->get("nomProduit")."\n";
                        echo  "Prix : ".$array[$i]->get("prix")."\n";
                        echo "Taille : ".$array[$i]->get("taille")."\n \n";
                    
                }
            
        }
        else 
            echo "Votre panier est vide";
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
            $_SESSION['panier']=array(0 =>$produit,);
        else
            array_push($_SESSION['panier'],$produit);

        //header("Location: index.php?controller=produit&action=voirpanier");
    }

    public static function selectedproduit(){
        $view = "filtre";
        $pagetile = "Produits";
        require (File::buildpath(array("view","view.php")));
        $tab = ModelProduits::selectAll();
        $prixComp = 5000;

        if ($_POST['prix'] > 1 && $_POST['prix'] < 101) {
            $prixComp = $_POST['prix'];
        }

        echo "<div class =\"divProduit\">";
        foreach($tab as $u){ 
            if ((int)$u->get("numCategorie") == (int)$_POST['categorie'] && $u->get("prix") <= $prixComp) {
                echo "<div class =\"containerProduit\">";
                echo "<img src=\"" . $u->get("imgPath"). "\">";
                echo "<div class=\"nomProduit\">" . $u->get("nomProduit") . "</div>";
                echo "<div class=\"descriptionProduit\">" . $u->get("descriptionProduit") . "</div>";
                echo "<div class=\"prixProduit\">" . $u->get("prix") . " EUR</div>";
                echo "</div>";
            }
        }
        echo "</div>";
    }
}



?>