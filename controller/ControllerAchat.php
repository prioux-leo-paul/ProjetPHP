<?php
require_once File::buildpath(array("model","ModelAchats.php"));
require_once File::buildpath(array("model","ModelLivraisons.php"));
require_once File::buildpath(array("model","ModelProduits.php")); // chargement du modèle

class ControllerAchat {
    protected static $object ="achats";
    public static function commander() {
    
        $view = "formlivraison";
        $pagetitle = "commander";
        require (File::buildpath(array("view","view.php")));
           
        if(isset($_SESSION['numMembre'])){


            if(isset($_POST['liv']) && isset($_POST['adr'])){
                for($i = 0; $i < count($_SESSION['panier']['numProduit']); $i++ ){
                    $liststock = ModelTailles::selectAllPrimary($_SESSION['panier']['numProduit'][$i]);
                    foreach($liststock as $taille){
                        if($taille->get("taille") == $_SESSION['panier']['tailleProduit'][$i]){
                            $stock = $taille->get("stock");
                            if($stock > $_SESSION['panier']['qteProduit'][$i]){
                                $achat = new ModelAchats($_SESSION['numMembre'],$_SESSION['panier']['numProduit'][$i],$_SESSION['panier']['qteProduit'][$i],$_SESSION['panier']['tailleProduit'][$i]);
                                $saveok = $achat->save();
                                $achat->majnumachat();
                                if($_POST['liv'] == 1){
                                    $jour = getdate();
                                    $mod = strtotime($jour."+ 6 days");
                                    date('Y-m-d',$mod);
                                    
                                }
                                else{
                                    $jour = getdate();
                                    $mod = strtotime($jour."+ 2 days");
                                    date('Y-m-d',$mod);
                                    
                                }
                                $livraison = new ModelLivraisons($achat->get("numAchat"),$_POST['adr'],$jour);
                                $saveok2 = $livraison->save();
                                unset($_SESSION['panier']);
                                echo "<p> votre commande a été pris en compte </p>";
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