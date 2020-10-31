<?php
require_once 'Model.php';
class ModelMembres {

    private pseudoMembre;
    private mailMembre;
    private mdpMembre; 
    private panierMembre;

    public function __construct($pseudoMembre, $mailMembre, $mdpMembre){
        $this->pseudoMembre = $pseudoMembre;
        $this->mail = $mailMembre;
        $this->mdp = $mdpMembre;
        $this->panierMembre = array();
    }

    public function save() {
        try {
            $sql = "INSERT INTO PRODUITS ( pseudoMembre, mailMembre, mdpMembre) VALUES (?,?,?)";
            echo $sql;
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);

            $values = array( $this->pseudoMembre, $this->mail, $this->mdp);
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

    public function ajouterPanier($produit){
        $this->panierMembre = array($produit,$this->panierMembre);
    }

    public function getAllCommande(){
        
    }



}


