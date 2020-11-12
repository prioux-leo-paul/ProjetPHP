<?php
session_start();
require_once File::buildpath(array("model","Model.php"));
class ModelMembres {

    private $numMembre;
    private $pseudoMembre;
    private $mailMembre;
    private $mdpMembre;
    private $panierMembre;


    public function __construct($pseudoMembre, $mailMembre, $mdpMembre){
        $this->numMembre = null;
        $this->pseudoMembre = $pseudoMembre;
        $this->mail = $mailMembre;
        $this->mdp = $mdpMembre;
        $this->panierMembre = array();
    }

    public function save() {
        try {
            $sql = "INSERT INTO MEMBRES ( pseudoMembre, mailMembre, mdpMembre) VALUES (?,?,?)";
            
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);

            $values = array( $this->pseudoMembre, $this->mail, $this->mdp);
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

       
            //verifie si le mdp et le mail sont bon
            if (!empty($mdpconnect) AND !empty($mailconnect)) {
                $requser = Model::$pdo->prepare("SELECT * FROM MEMBRES WHERE mailMembre = ? AND mdpMembre = ?");
                $requser->execute(array($mailconnect,$mdpconnect));
                $userexist = $requser->rowCount();
                if($userexist == 1){
                    //creation de session et redirection
                    $userinfo = $requser->fetch();
                    $_SESSION['numMembre'] = $userinfo['numMembre'];
                    $_SESSION['pseudoMembre'] = $userinfo['pseudoMembre'];
                    $_SESSION['mailMembre'] = $userinfo['mailMembre'];
                    $membre = new ModelMembres(array("pseudoMembre"=>$_SESSION['pseudoMembre'],"mailMembre"=>$_SESSION['mailMembre'],"mdpMembre"=>$mdpconnect));
                    $membre->setnumMembre($_SESSION['numMembre']);
                    echo "c'est bon";
                    
                }
                else{
                   echo "Mauvais mail ou mot de passe !";
                }
            }
            else{
                echo "Tous les champs doivent être complété !";
            }
    
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
}
?>