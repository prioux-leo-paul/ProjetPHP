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
        $pagetitle = "Produits";
        require (File::buildpath(array("view","view.php")));
        $tab = ModelProduits::selectAll();
        echo "<div class =\"divProduit\">";
        foreach($tab as $u){
                echo "<div class =\"containerProduit\"><a href=\"index.php?controller=produit&action=showproduct&param=".$u->get("numProduit")."\">";
                echo "<img class=\"dimension_img\" src=\"" . $u->get("imgPath"). "\">";
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
        ControllerProduit::supprimerArticle2($nump);
        header("Location: index.php?controller=produit&action=voirpanier");
    }

    public static function supprimerArticle2($nump){
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
    }
    

    public static function showproduct($param){
        $current_product = ModelProduits::selectPrimary($param);
        $current_numcategory = $current_product->get("numCategorie");
        $current_category = ModelCategories::selectPrimary($current_numcategory);
        $view = "produitgenerique";
        $nump = $param;
        $pagetitle = $current_product->get("nomProduit");
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
           ControllerProduit::supprimerArticle($nump);
        }
        else
        $erreur = "<p> Un problème est survenu rééssayez. </p>";
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

                echo "<div class =\"containerProduit\"><a href=\"index.php?controller=produit&action=showproduct&param=".$u->get("numProduit")."\">";
                echo "<img class=\"dimension_img\" src=\"" . $u->get("imgPath"). "\">";
                echo "<div class=\"nomProduit\">" . $u->get("nomProduit") . "</div>";
                echo "<div class=\"descriptionProduit\">" . $u->get("descriptionProduit") . "</div>";
                echo "<div class=\"prixProduit\">" . $u->get("prix") . " EUR</a></div>";
                echo "</div>";
            }
        }
        echo "</div>";
    }


    //partie admin

    public static function allproduitadmin(){
        if(isset($_SESSION['estadmin'])){
            if($_SESSION['estadmin'] == 1){
                $view = "filtreadmin";
                $pagetitle = "Produits admin";
                require (File::buildpath(array("view","view2.php")));
                $tab = ModelProduits::selectAll();
                echo "<div class =\"divProduit\">";
                foreach($tab as $u){
                        echo "<div class =\"containerProduit\"><a href=\"index.php?controller=produit&action=showproductadmin&param=".$u->get("numProduit")."\">";
                        echo "<img src=\"" . $u->get("imgPath"). "\">";
                        echo "<div class=\"nomProduit\">" . $u->get("nomProduit") . "</div>";
                        echo "<div class=\"descriptionProduit\">" . $u->get("descriptionProduit") . "</div>";
                        echo "<div class=\"prixProduit\">" . $u->get("prix") . " EUR</a></div>";
                        echo "</div>";
                }
                echo "</div>";

            }
        }
        
    }

    public static function selectedproduitadmin(){
        if(isset($_SESSION['estadmin'])){
            if($_SESSION['estadmin'] == 1){
                $view = "filtreadmin";
                $pagetitle = "Produits admin";
                require (File::buildpath(array("view","view2.php")));
                $tab = ModelProduits::selectAll();
                $prixComp = 5000;

                if ($_POST['prix'] > 1 && $_POST['prix'] < 101) {
                    $prixComp = $_POST['prix'];
                }

                echo "<div class =\"divProduit\">";
                foreach($tab as $u){ 
                    if ((int)$u->get("numCategorie") == (int)$_POST['categorie'] && $u->get("prix") <= $prixComp) {
                        echo "<div class =\"containerProduit\"><a href=\"index.php?controller=produit&action=showproductadmin&param=".$u->get("numProduit")."\">";
                        echo "<img src=\"" . $u->get("imgPath"). "\">";
                        echo "<div class=\"nomProduit\">" . $u->get("nomProduit") . "</div>";
                        echo "<div class=\"descriptionProduit\">" . $u->get("descriptionProduit") . "</div>";
                        echo "<div class=\"prixProduit\">" . $u->get("prix") . " EUR</a></div>";
                    }
                }
                echo "</div>";
            }
        }
    }

    public static function showproductadmin($param){
        if(isset($_SESSION['estadmin'])){
            if($_SESSION['estadmin'] == 1){
                
                $current_product = ModelProduits::selectPrimary($param);
                $current_numcategory = $current_product->get("numCategorie");
                $current_category = ModelCategories::selectPrimary($current_numcategory);

                if(isset($_POST['envoyer'])){
                    if(isset($_POST['nomp']) && !empty($_POST['nomp'])){
                        $array=array("numProduit" => $param,"nomProduit" => $_POST['nomp'],);
                        ModelProduits::update($array);
                    }
                    if(isset($_POST['prixp']) && !empty($_POST['prixp'])){
                        $array=array("numProduit" => $param,"prix" => $_POST['prixp'],);
                        ModelProduits::update($array);
                    }
                    if(isset($_POST['descrip']) && !empty($_POST['descrip'])){
                        $array=array("numProduit" => $param,"descriptionProduit" => $_POST['descrip'],);
                        ModelProduits::update($array);
                    }
                    
                }
                if(isset($_POST['envoyer2'])){
                        if(isset($_POST['q']) && !empty($_POST['q'])){
                            $q = $_POST['q'] ;
                            if (is_array($q)){
                                $stock = array();
                                $i=0;
                                foreach ($q as $contenu){
                                   $stock[$i++] = intval($contenu);
                                }
                             }
                             else
                                 $q = intval($q);
                            $t = $_POST['t'] ;
                            if (is_array($q)){
                                $taille = array();
                                $i=0;
                                foreach ($t as $contenu){
                                    $taille[$i++] = $contenu;
                                }
                            }
                            
                    
                            for ($i = 0 ; $i < count($stock) ; $i++)
                            {
                            if(round($stock[$i]) >= 0){
                                ModelTailles::updatestock2(round($stock[$i]),$param,$taille[$i]);
                            }
                            
                            }
                        }
                }
                if(isset($_POST['envoyer3'])){
                    if(isset($_POST['newtaille']) && !empty($_POST['newtaille']) && isset($_POST['newstock']) && !empty($_POST['newstock'])){
                        $test = ModelTailles::tailleexist($param,$_POST['newtaille']);
                        if(!$test){
                            $taille = new ModelTailles($param,$_POST['newtaille'],$_POST['newstock']);
                            $saveok = $taille->save();
                            
                        }
                        else
                            ModelTailles::updatestock(round(intval($_POST['newstock'])),$param,round(intval($_POST['newtaille'])));


                    }
                }
                $current_product = ModelProduits::selectPrimary($param);
                $current_numcategory = $current_product->get("numCategorie");
                $current_category = ModelCategories::selectPrimary($current_numcategory);
                $view = "produitgeneriqueadmin";
                $nump = $param;
                $pagetitle = $current_product->get("nomProduit");
                require (File::buildpath(array("view","view2.php")));
            }
        }
    }

    public static function supprimerarticleadmin($param){
        if(isset($_SESSION['estadmin'])){
            if($_SESSION['estadmin'] == 1){
                ModelProduits::delete($param);
                ModelTailles::delete($param);
                header("Location: index.php?controller=produit&action=allproduitadmin");

            }
        }
    }

    public static function supptailleadmin($param){
        if(isset($_SESSION['estadmin'])){
            if($_SESSION['estadmin'] == 1){
                ModelTailles::supprimertaille($param);
                header("Location: index.php?controller=produit&action=allproduitadmin");
                
            }
        }
    }

    public static function formajouterproduit(){
        if(isset($_SESSION['estadmin'])){
            if($_SESSION['estadmin'] == 1){
                $view = "ajouterunproduit";
                $pagetitle ="Ajouter un produit";
                require (File::buildpath(array("view","view2.php")));
            }
        }
    
    }
    public static function ajouterproduit(){
        if(isset($_SESSION['estadmin'])){
            if($_SESSION['estadmin'] == 1){
                if(isset($_POST['envoyer']) ){
                    if(!empty($_POST['nom']) && !empty($_POST['prix']) && !empty($_POST['des']) && !empty($_POST['categorie']) && !empty($_FILES['photo'])){
     
                        $tailleMax = 2097152; //2097152 taille de 2 MO
                        $extensionsValides = array('jpg','jpeg','gif','png');
                        //comparaison de la taille
                        if($_FILES['photo']['size'] <= $tailleMax){
                            //recuperation de l'extension upload
                            $extentionUpload =strtolower(substr(strrchr($_FILES['photo']['name'],'.'),1));
                            //verif de l'extension
                            if(in_array($extentionUpload,$extensionsValides)){
                                $nomC = ModelCategories::selectPrimary($_POST['categorie']);
                                $chemin ='Image/Produits/'.$nomC->get("nomCategorie").'/'.$_FILES['photo']['name'];
                                //mettre dans le bon chemin
                                
                                $resultat = move_uploaded_file($_FILES['photo']['tmp_name'],$chemin);
                                if($resultat){
                                    $new_produit = new ModelProduits($_POST['nom'],$_POST['categorie'],$_POST['prix'],$_POST['des'],$chemin);
                                    $saveok = $new_produit->save();

                                    if($saveok)
                                        $erreur = "votre produit a bien été enregistrer";
                                    else    
                                        $erreur = "il y a eu une erreur";
                                }
                                else{
                                    $erreur = "Erreur durant l'importation de votre photo !";
                                }
                            }
                            else{
                                $erreur = "Votre photo doit être au format jpg, jpeg, gif, png";
                            }
                        }
                        else{
                            $erreur = "Votre photo ne doit pas dépasser 2 Mo !";
                        }

                        

                }
                else
                    $erreur = "vous devez remplir tous les champs";

            }

                $view = "ajouterunproduit";
                $pagetitle ="Ajouter un produit";
                require (File::buildpath(array("view","view2.php")));
            }
        }
    }

}



?>