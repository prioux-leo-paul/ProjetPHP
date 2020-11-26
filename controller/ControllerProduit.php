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
                echo "<div class =\"containerProduit\"><a href=\"index.php?controller=produit&action=showproduct&param=".$u->get("numProduit")."\">";
                echo "<img src=\"" . $u->get("imgPath"). "\">";
                echo "<div class=\"nomProduit\">" . $u->get("nomProduit") . "</div>";
                echo "<div class=\"descriptionProduit\">" . $u->get("descriptionProduit") . "</div>";
                echo "<div class=\"prixProduit\">" . $u->get("prix") . " EUR</a></div>";
                echo "</div>";
        }
        echo "</div>";
        
    }

    

    public static function ajouterpanier($produit,$taille,$qte){
        $produit->set("taille",$taille);

        if(!isset($_SESSION['panier'])){
            $_SESSION['panier']=array();
            $_SESSION['panier']['numProduit'] = array($produit->get("numProduit"));
            $_SESSION['panier']['tailleProduit'] = array($produit->get("taille"));
            $_SESSION['panier']['libelleProduit'] = array($produit->get("nomProduit"));
            $_SESSION['panier']['qteProduit'] = array($qte);
            $_SESSION['panier']['prixProduit'] = array($produit->get("prix"));

            
        }
        else{
            $positionProduit = array_search($produit->get("numProduit"),  $_SESSION['panier']['numProduit']);

                if ($positionProduit !== false)
            {
                $_SESSION['panier']['qteProduit'][$positionProduit] += $qte ;
            }
            else{
            array_push( $_SESSION['panier']['libelleProduit'],$produit->get("nomProduit"));
            array_push( $_SESSION['panier']['qteProduit'],$qte);
            array_push( $_SESSION['panier']['prixProduit'],$produit->get("prix"));
            array_push( $_SESSION['panier']['numProduit'],$produit->get("numProduit"));
            array_push( $_SESSION['panier']['tailleProduit'],$produit->get("taille"));
            }
        }

        echo "<p> votre produit a été mis dans votre panier ! </p>";

    }

    public static function supprimerArticle($nump){
        //Si le panier existe
        
           //Nous allons passer par un panier temporaire
           $tmp=array();
           $tmp['libelleProduit'] = array();
           $tmp['qteProduit'] = array();
           $tmp['prixProduit'] = array();
           $tmp['numProduit'] = array();
           $tmp['tailleProduit'] = array();
           
     
           for($i = 0; $i < count($_SESSION['panier']['numProduit']); $i++)
           {
              if ($_SESSION['panier']['numProduit'][$i] !== $nump)
              {
                 array_push( $tmp['libelleProduit'],$_SESSION['panier']['libelleProduit'][$i]);
                 array_push( $tmp['qteProduit'],$_SESSION['panier']['qteProduit'][$i]);
                 array_push( $tmp['prixProduit'],$_SESSION['panier']['prixProduit'][$i]);
                 array_push( $tmp['numProduit'],$_SESSION['panier']['numProduit'][$i]);
                 array_push( $tmp['tailleProduit'],$_SESSION['panier']['tailleProduit'][$i]);
              }
     
           }
           //On remplace le panier en session par notre panier temporaire à jour
           $_SESSION['panier'] =  $tmp;
           //On efface notre panier temporaire
           unset($tmp);
           header("Location: index.php?controller=produit&action=voirpanier");
        
    }

    public static function showproduct($param){
        $current_product = ModelProduits::selectPrimary($param);
        $current_numcategory = $current_product->get("numCategorie");
        $current_category = ModelCategories::selectPrimary($current_numcategory);
        $view = "produitgenerique";
        $nump = $param;
        $pagetile = $current_product->get("nomProduit");
        require (File::buildpath(array("view","view.php")));
    }

    public static function voirpanier(){
        $view = "panier";
        $pagetitle = "Panier";
        require (File::buildpath(array("view","view.php")));
        
    }

    public static function modifierQTeArticle($taillep,$nump,$qteProduit){
        //Si le panier existe
        if (isset($_SESSION['panier']))
        {
            $liststock = ModelTailles::selectAllPrimary($nump);
            foreach($liststock as $taille){
                if($taille->get("taille") == $taillep)
                    $stock = $taille->get("stock");
            }
           //Si la quantité est positive on modifie sinon on supprime l'article
           if ($qteProduit > 0)
           {
               if($qteProduit < $stock){
                    //Recharche du produit dans le panier
                    $positionProduit = array_search($nump,  $_SESSION['panier']['numProduit']);
            
                    if ($positionProduit !== false)
                    {
                        $_SESSION['panier']['qteProduit'][$positionProduit] = $qteProduit ;
                    }
                }
           }
           else
           supprimerArticle($libelleProduit);
        }
        else
        echo "<p> Un problème est survenu rééssayez. </p>";
     }

    public static function MontantGlobal(){
        $total=0;
        if(isset($_SESSION['panier'])){
            for($i = 0; $i < count($_SESSION['panier']['libelleProduit']); $i++)
            {
            $total += $_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i];
            }
        }
        return $total;
     }
        

    public static function selectedproduit(){
        $view = "filtre";
        $pagetitle = "Produits";
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