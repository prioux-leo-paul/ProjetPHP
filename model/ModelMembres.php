<?php

require_once File::buildpath(array("model","Model.php"));
require_once File::buildpath(array("lib","Security.php"));
class ModelMembres extends Model {
    protected static $object = "membres";
    protected static $primary = "numMembre";
    private $numMembre;
    private $pseudoMembre;
    private $mailMembre;
    private $mdpMembre;
    private $confirmCompte;
    private $confirmKey;
    private $estadmin;


    public function __construct($pseudo = NULL, $mail = NULL, $mdp = NULL,$Key = NULL){
        if ( !is_null($pseudo) && !is_null($mail) && !is_null($mdp) && !is_null($Key)){
            $this->pseudoMembre = $pseudo;
            $this->mailMembre = $mail;
            $this->mdpMembre = $mdp;
            $this->confirmKey = $Key;
       }
    }
    public function get($nom_attribut) {
        if (property_exists($this, $nom_attribut))
            return $this->$nom_attribut;
        return false;
    }

    public function set($nom_attribut,$valeur) {
        $this->$nom_attribut = $valeur; 
    }

    
    public function save() {
        try {
            $sql = "INSERT INTO membres ( pseudoMembre, mailMembre, mdpMembre, confirmCompte,confirmKey, estadmin) VALUES (?,?,?,?,?,?)";
            
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);

            $values = array( $this->pseudoMembre, $this->mailMembre, $this->mdpMembre, 0 , $this->confirmKey, 0);
            // On donne les valeurs et on exécute la requête	 
            $req_prep->execute($values);
            
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
            } else {
                $lien = File::buildpath(array("controller","routeur.php?action=formlogin"));
                echo " Votre compte a bien été creer ! <a href=\"".$lien."\">Me connecter</a>";
            }
            die();
        }
    }

    public function ajouterPanier($produit){
        $this->panierMembre = array($produit,$this->panierMembre);
    }

    

    public static function verifMembre( $mailconnect, $mdpconnect){

            $mailconnect =htmlspecialchars($mailconnect);
            $mdpconnect=Security::hacher($mdpconnect);
            
            //verifie si le mdp et le mail sont bon
            if (!empty($mdpconnect) AND !empty($mailconnect)) {
                if(!ModelMembres::userexist($mailconnect))
                    return "l'utilisateur n'existe pas !";
                
                $requser = Model::$pdo->prepare("SELECT * FROM membres WHERE mailMembre = ? AND mdpMembre = ?");
                $requser->execute(array($mailconnect,$mdpconnect));
                $exist = $requser->rowCount();
                if($exist == 1){
                    //creation de session et redirection
                    $userinfo = $requser->fetch();
                    $membre = new ModelMembres($userinfo['pseudoMembre'],$mailconnect,$mdpconnect,$userinfo['confirmKey']);
                    $membre->set("numMembre",$userinfo['numMembre']);
                    $membre->set("confirmCompte",$userinfo['confirmCompte']);
                    $membre->set("estadmin",$userinfo['estadmin']);
                    return $membre;
                    
                }
                else{
                   return "<p> Mauvais mail ou mot de passe ! </p>";
                }
            }
            else{
                return "<p> Tous les champs doivent être complété ! </p>";
            }

    
    }

    

    public static function getwithmail($mailconnect,$valeur){
        $requser = Model::$pdo->prepare("SELECT * FROM membres WHERE mailMembre= ?");
        $requser->execute(array($mailconnect));
        $user = $requser->fetch();
        if(empty($user))
            return 2;
        return $user[$valeur];
    }

    

    public static function compteconfirmer($mail,$Key){
        $updateuser = Model::$pdo->prepare("UPDATE membres SET confirmCompte = 1 WHERE mailMembre = ? AND confirmKey = ?");
        $updateuser->execute(array($mail,$Key));
    }

    private function setnumMembre($numMembre){
        $this->numMembre = $numMembre;
    }


    public static function userexist($mail){
        $reqmail = Model::$pdo->prepare("SELECT * FROM membres WHERE mailMembre= ?");
        $reqmail->execute(array($mail));
        $mailexist = $reqmail->rowCount();
        if ($mailexist == 0){
            return false;
        }
        else{
            return true;
        }
    }

    public static function commandeAll($numMembre){
        $req = Model::$pdo->prepare("SELECT * FROM membres WHERE numMembre= ?");
        $req->execute(array($numMembre));
    }

    public static function updateMembre($categorie,$valeur){
        $req = Model::$pdo->prepare("UPDATE membres SET $categorie = ? WHERE numMembre = ?");
        $req->execute(array($valeur,$_SESSION['numMembre']));
    }

    public static function supprimerMembre(){
        $req = Model::$pdo->prepare("DELETE FROM membres WHERE numMembre = ?");
        $req->execute(array($_SESSION['numMembre']));
    }

    
}

?>