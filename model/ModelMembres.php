<?php

require_once File::buildpath(array("model","Model.php"));
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


    public function __construct($pseudoMembre = NULL, $mailMembre = NULL, $mdpMembre = NULL,$confirmKey = NULL){
        if ( !isnull($pseudoMembre) && !is_null($mailMembre) && !is_null($mdpMembre) && !is_null($confirmKey)){
            $this->numMembre = null;
            $this->pseudoMembre = $pseudoMembre;
            $this->mail = $mailMembre;
            $this->mdp = $mdpMembre;
            
            $this->$confirmCompte = 0;
            $this->$estadmin = 0;
            $this->$confirmKey = $confirmKey;
       }
    }
    public function get($nom_attribut) {
        if (property_exists($this, $nom_attribut))
            return $this->$nom_attribut;
        return false;
    }

    
    public function save() {
        try {
            $sql = "INSERT INTO MEMBRES ( pseudoMembre, mailMembre, mdpMembre, confirmCompte,confirmKey, estadmin) VALUES (?,?,?,?,?,?)";
            
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);

            $values = array( $this->pseudoMembre, $this->mail, $this->mdp, 0 , $this->confirmKey, 0);
            // On donne les valeurs et on exécute la requête	 
            $req_prep->execute($values);
            
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
            } else {
                $lien = File::buildpath(array("controller","routeur.php?action=formlogin"));
                echo "Votre compte a bien été creer ! <a href=\"".$lien."\">Me connecter</a>";
            }
            die();
        }
    }

    public function ajouterPanier($produit){
        $this->panierMembre = array($produit,$this->panierMembre);
    }

    

    public static function verifMembre( $mailconnect, $mdpconnect){

            $mailconnect =htmlspecialchars($mailconnect);
            $mdpconnect=sha1($mailconnect);
            //verifie si le mdp et le mail sont bon
            if (!empty($mdpconnect) AND !empty($mailconnect)) {

                $requser = Model::$pdo->prepare("SELECT * FROM MEMBRES WHERE mailMembre= ?");
                $requser->execute(array($mailconnect));
                $requser2 = Model::$pdo->prepare("SELECT mailMembre FROM MEMBRES WHERE mdpMembre= ?");
                $requser2->execute(array($mdpconnect));
                $user = $requser2->fetch();
                
                
                if($user == $mailconnect){
                    //creation de session et redirection
                    $userinfo = $requser->fetch();
                    $membre = new ModelMembres($userinfo['pseudoMembre'],$mailconnect,$mdpconnect,$userinfo['confirmKey']);
                    $membre->setnumMembre($userinfo['numMembre']);
                    return true;
                    
                }
                else{
                   return "Mauvais mail ou mot de passe !";
                }
            }
            else{
                return "Tous les champs doivent être complété !";
            }

    
    }

    

    public static function getwithmail($mailconnect,$valeur){
        $requser = Model::$pdo->prepare("SELECT * FROM MEMBRES WHERE mailMembre= ?");
        $requser->execute(array($mailconnect));
        $user = $requser->fetch();
        return $user[$valeur];
    }

    

    public static function compteconfirmer($mail,$Key){
        $updateuser = Model::$pdo->prepare("UPDATE MEMBRES SET confirmCompte = 1 WHERE mailMembre = ? AND confirmKey = ?");
        $updateuser->execute(array($mail,$Key));
    }

    private function setnumMembre($numMembre){
        $this->numMembre = $numMembre;
    }


    public static function userexist($mail){
        $reqmail = Model::$pdo->prepare("SELECT * FROM MEMBRES WHERE mailMembre= ?");
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
        $req = Model::$pdo->prepare("SELECT * FROM MEMBRES WHERE numMembre= ?");
        $req->execute(array($numMembre));
    }

    public static function updateMembre($categorie,$valeur){
        $req = Model::$pdo->prepare("UPDATE MEMBRES SET $categorie = ? WHERE numMembre = ?");
        $req->execute(array($valeur,$_SESSION['numMembre']));
    }

    public static function supprimerMembre(){
        $req = Model::$pdo->prepare("DELETE FROM MEMBRES WHERE numMembre = ?");
        $req->execute(array($_SESSION['numMembre']));
    }
}

?>