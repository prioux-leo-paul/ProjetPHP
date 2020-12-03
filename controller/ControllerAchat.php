<?php
require_once File::buildpath(array("model","ModelAchats.php"));
require_once File::buildpath(array("model","ModelLivraisons.php"));
require_once File::buildpath(array("model","ModelProduits.php")); // chargement du modèle

class ControllerAchat {
    protected static $object ="achats";
    public static function commander() {
    
        ControllerAchat::formcommander();
           
        if(isset($_SESSION['numMembre'])){


            if(isset($_POST['liv']) && isset($_POST['adr'])){
                $c = count($_SESSION['panier']['numProduit']);
                
                for($i = 0; $i < $c ; $i++ ){
                    $liststock = ModelTailles::selectAllPrimary($_SESSION['panier']['numProduit'][$i]);
                    foreach($liststock as $taille){
                        
                        if(isset( $_SESSION['panier']['tailleProduit'][$i])){
                            if($taille->get("taille") == $_SESSION['panier']['tailleProduit'][$i]){
                                
                                $stock = $taille->get("stock");
                                if($stock > $_SESSION['panier']['qteProduit'][$i]){
                                    $achat = new ModelAchats($_SESSION['numMembre'],$_SESSION['panier']['numProduit'][$i],$_SESSION['panier']['qteProduit'][$i],$_SESSION['panier']['tailleProduit'][$i]);
                                    $saveok = $achat->save();
                                    $achat->majnumachat();
                                    if($_POST['liv'] == 1){
                                        $mod = $date = new DateTime("+ 6 days");
                                        
                                    }
                                    else{
                                        $mod = $date = new DateTime("+ 2 days");
                                    }
                                    $livraison = new ModelLivraisons($achat->get("numAchat"),$_POST['adr'],$mod->format('Y-m-d'));
                                    $saveok2 = $livraison->save();
                                    
                                    if ($saveok && $saveok2 ){
                                        echo "<p> Votre article ".$_SESSION['panier']['libelleProduit'][$i]." a bien été commandé </p>";
                                        $new_stock = $stock - $_SESSION['panier']['qteProduit'][$i];
                                        ModelTailles::updatestock($new_stock,$_SESSION['panier']['numProduit'][$i],$_SESSION['panier']['tailleProduit'][$i]);
                                        ControllerProduit::supprimerArticle2($_SESSION['panier']['numProduit'][$i]);
                                        
                                    }
                                    else 
                                        echo "<p> Votre article ".$_SESSION['panier']['libelleProduit'][$i]." n'a pas été commandé, veuillez réessayé </p>";
                                } 
                            }
                        }
                    }
                    
                }
                
                
            }
            
        }
        else{
            echo "<p> Vous n'êtes pas connecter ! </p>";
            echo "<p><a href=\"index.php?action=Home\"> connexion</a></p>";
        }
        
    }

    public static function formcommander(){
        $view = "formlivraison";
        $pagetitle = "commander";
        require (File::buildpath(array("view","view.php")));
    }

    public static function showachats($param){
        $current_achat = ModelAchats::selectPrimary($param);
        $poduct_achat = ModelProduits::selectPrimary($current_achat->get("numProduit"));
        $img = ModelProduits::majimg($poduct_achat->get("numProduit"));
        $livraison_achat = ModelLivraisons::selectbyachat($param);
        
        $view = "achatsgenerique";
        $pagetitle = "Details commande";
        require (File::buildpath(array("view","view.php")));
    }

}

?>