<?php
require_once File::buildpath(array("model","Model.php"));
class ModelAchats {

    private numClient;
    private numProduit;
    private qteAchat;
    private dateAchat; 

    public function __construct($numClient, $numProduit, $qteAchat){
        $this->numClient = $numClient;
        $this->numProduit = $numProduit;
        $this->qteAchat = $qteAchat;
        $this->dateAchat = getdate();
    }

    public function save() {
        try {
            $sql = "INSERT INTO ACHATS ( numClient, numProduit, qteAchat, dateAchat) VALUES (?,?,?)";
            echo $sql;
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);

            $values = array( $this->numClient, $this->numProduit, $this->qteAchat, $this->dateAchat);
            // On donne les valeurs et on exécute la requête	 
            $req_prep->execute($values);
            echo $sql;
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
            } else {
                echo "Votre compte a bien été creer ! <a href=\"../controller/router.php?action=formlogin\">Me connecter</a>";
            }
            die();
        }
    }





}