<?php

require_once File::buildpath(array("model","ModelMembres.php")); // chargement du modèle

class ControllerMembre {

    public static function Home() {
        $controller = "membres";
        $view = "Home";
        $pagetitle = "Page d'acceuil";
        require File::buildpath(array("view","view.php"));
        
    }

    public static function formregister() {
        $controller = "membres";
        $view = "register";
        $pagetitle = "S'enregistrer";
        require File::buildpath(array("view","view.php"));
    }

    public static function register(){
        require_once File::buildpath(array("model","ModelMembres.php"));
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mail = htmlspecialchars($_POST['mail']);
        $mail2 = htmlspecialchars($_POST['mail2']);
        $mdp = sha1($_POST['mdp']);
        $mdp2 = sha1($_POST['mdp2']);
        $pseudolength = strlen($pseudo);
        if (!empty($pseudo) AND !empty($mail) AND !empty($mail2) AND !empty($mdp) AND !empty($mdp2)) {
            //verification des info
            if ($pseudolength <= 50) {
                    if($mail == $mail2){
                        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                            $testmail = ModelMembres::userexist($mail);
                            if($testmail == false){
                                if($mdp == $mdp2){
                                $membre = new ModelMembres($pseudo,$mail,$mdp);
                                $saveok = $membre->save();
                                header("Location: index.php?action=formlogin");
                                }else {
                                    echo "Vos mot de passe ne corresponde pas !";
                                }
                            }else {
                                echo "Adresse mail déjà utilisée !";
                            }
                        }else {
                            echo "Votre adresse mail n'est pas valide !";
                        }
                    }else {
                        echo "Vos adresse mail ne corresponde pas !";
                    }    
            } else {
                echo "Votre pseudo doit contenir moins de 255 charactère !";
            }
        } else{ 
            echo "Tous les champs doivent etre complété !";

        }
    }

    public static function formlogin() {
        $pagetitle = "Se connecter";
        $controller = "membres";
        $view = "login";
        require File::buildpath(array("view","view.php"));
    }

    public static function login(){
        ControllerMembre::formlogin();
        require_once File::buildpath(array('model','ModelMembres.php'));
        
        $mailconnect = $_POST['mailconnect'];
        $mdpconnect = $_POST['mdpconnect'];
        
        $test = ModelMembres::verifMembre( $mailconnect, $mailconnect);
        if ($test ==true ){
            header("Location: index.php?action=Home");
        }
        else{
            echo $test;
        }
        
        
    }

    public static function logout(){
    $_SESSION = array();
    session_destroy();
    header("Location: index.php?action=Home");
    }


    public static function profile(){
        echo $_SESSION['pseudoMembre'];


        echo "Mes comandes"
        
    }


    
}
?>