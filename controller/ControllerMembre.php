<?php
session_start();
require_once ('../model/ModelMembres.php'); // chargement du modèle

class ControllerMembre {

    public static function Home() {
        require ('../view/Home.php');
    }

    public static function formregister() {
        require ('../view/Membres/register.php');
    }

    public static function register(){
        require_once ('../model/ModelMembres.php');
        $pseudo = htmlspecialchars($_GET['pseudo']);
        $mail = htmlspecialchars($_GET['mail']);
        $mail2 = htmlspecialchars($_GET['mail2']);
        $mdp = sha1($_GET['mdp']);
        $mdp2 = sha1($_GET['mdp2']);
        $pseudolength = strlen($pseudo);
        if (!empty($pseudo) AND !empty($mail) AND !empty($mail2) AND !empty($mdp) AND !empty($mdp2)) {
            //verification des info
            if ($pseudolength <= 50) {
                    if($mail == $mail2){
                        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                            
                        $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail= ?");
                        $reqmail->execute(array($mail));
                        $mailexist = $reqmail->rowCount();
                        if($mailexist == 0){
                            if($mdp == $mdp2){
                            $membre = new ModelMembres(array("pseudoMembre"=>$pseudo,"mailMembre"=>$mail,"mdpMembre"=>$mdp));
                            $saveok = $membre->save();
                            }else {
                                $erreur = "Vos mot de passe ne corresponde pas !";
                            }
                        }else {
                            $erreur = "Adresse mail déjà utilisée !";
                        }
                    }else {
                        $erreur = "Votre adresse mail n'est pas valide !";
                        }else {
                        $erreur = "Vos adresse mail ne corresponde pas !";
                    }
                
            } else {
                $erreur ="Votre pseudo doit contenir moins de 255 charactère !";
            }
        } else{ 
            $erreur ="Tous les champs doivent etre complété !";

        }
    }

    public static function formlogin() {
        require ('../view/Membres/login.php');
    }

    public static function login(){
        if (isset($_GET['formconnexion'])) {
            $mailconnect=htmlspecialchars($_GET['mailconnect']);
            $mdpconnect= sha1($_GET['mdpconnect']);
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
                    header("Location: profil.php?id=".$_SESSION['id']);
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

    public static function logout(){
    $_SESSION = array();
    session_destroy();
    header("Location: index.php");
    }


    
}