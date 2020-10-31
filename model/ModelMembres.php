<?php
require_once File::buildpath(array("model","Model.php"));
class ModelMembres {

    private numMembre;
    private pseudoMembre;
    private mailMembre;
    private mdpMembre; 
    private panierMembre;

    public function __construct($pseudoMembre, $mailMembre, $mdpMembre){
        $this->numMembre = null;
        $this->pseudoMembre = $pseudoMembre;
        $this->mail = $mailMembre;
        $this->mdp = $mdpMembre;
        $this->panierMembre = array();
    }

    public function save() {
        try {
            $sql = "INSERT INTO PRODUITS ( pseudoMembre, mailMembre, mdpMembre) VALUES (?,?,?)";
            
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);

            $values = array( $this->pseudoMembre, $this->mail, $this->mdp);
            // On donne les valeurs et on exécute la requête	 
            $req_prep->execute($values);
            
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

    

    public static function verifMembre($formconnexion, $mailconnect, $mdpconnect){
        session_start();
        if (isset($formconnexion)) {
            //verifie si le mdp et le mail sont bon
            if (!empty($mdpconnect) AND !empty($mailconnect)) {
                $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND motdepasse = ?");
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
                    //header("Location: profil.php?id=".$_SESSION['numMembre']);
                }
                else{
                    $erreur = "Mauvais mail ou mot de passe !";
                }
            }
            else{
                $erreur = "Tous les champs doivent être complété !";
            }
        }
    }

    public function setnumMembre($numMembre){
        $this->numMembre = $numMembre;
    }


    public static function userexist($mail){
        $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail= ?");
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