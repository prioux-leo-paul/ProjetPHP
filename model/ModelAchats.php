<?php
require_once File::buildpath(array("model","Model.php"));
class ModelAchats {
    protected static $object = "achat";
    private $numClient;
    private $numProduit;
    private $qteAchat;
    private $ateAchat; 

    public function __construct($numClient, $numProduit, $qteAchat){
        $this->numClient = $numClient;
        $this->numProduit = $numProduit;
        $this->qteAchat = $qteAchat;
        $this->dateAchat = getdate();
    }

    public function save() {
        try {
            $sql = "INSERT INTO ACHATS ( numClient, numProduit, qteAchat, dateAchat) VALUES (?,?,?)";
            
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);

            $values = array( $this->numClient, $this->numProduit, $this->qteAchat, $this->dateAchat);
            // On donne les valeurs et on exécute la requête	 
            $req_prep->execute($values);
            
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
            } else {
                $lien = File::buildpath(array("controller","routeur.php?action=Home"));
                echo "Votre achats a bien été fait! <a href=\"".$lien."\">Home</a>";
            }
            die();
        }
    }





}
?>