<?php
session_start();
require_once File::buildpath(array("model","ModelMembres.php")); // chargement du modèle

class ControllerMembre {

    public static function Home() {
        $controller = "membres";
        $view = "Home";
        $pagetitle = "Page d'acceuil";
        require File::buildpath(array("view","view"));
    }

    public static function formregister() {
        $controller = "membres";
        $view = "register";
        $pagetitle = "S'enregistrer";
        require File::builpath(array("view","view"));
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
                            $testmail = ModelMembres::userexist($mail);
                            if($testmail == false){
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
                        }
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
        $pagetitle = "Se connecter";
        $controller = "membres";
        $view = "login";
        require File::buildpath(array("view","view"));
    }

    public static function login(){
        require_once File::path(array('model','ModelMembres.php'));
        $formconnexion = $_GET['formconnexion'];
        $mailconnect = htmlspecialchars($_GET['mailconnect']);
        $mdpconnect = sha1($_GET['mdpconnect']);
        ModelMembres::verifMembre($formconnexion, $mailconnect, $mailconnect);
    }

    public static function logout(){
    $_SESSION = array();
    session_destroy();
    header("Location: ../controller/router.php?action=Home");
    }


    
}