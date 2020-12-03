<?php

require_once File::buildpath(array("model","ModelMembres.php")); // chargement du modèle
require_once File::buildpath(array("lib","Security.php"));

class ControllerMembre {
    protected static $object= "membres";
    public static function Error() {
        $view = "error";
        $pagetitle = "Erreur";
        require File::buildpath(array("view","view.php"));
        
    }

    public static function Home() {
        $view = "Home";
        $pagetitle = "Page d'acceuil";
        require File::buildpath(array("view","view.php"));
        
    }

    public static function formregister() {
        $view = "update_create";
        $pagetitle = "S'enregistrer";
        $pseudoMembreHTML= "";
        $mailMembreHTML= "";
        $mdpMembreHTML= "";
        $primary_proprety = "required";
        $current_action = "register";
        require File::buildpath(array("view","view.php"));
        /*$view = "register";
        $pagetitle = "S'enregistrer";
        require File::buildpath(array("view","view.php"));*/
    }

    public static function register(){
        require_once File::buildpath(array("model","ModelMembres.php"));
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mail = htmlspecialchars($_POST['mail']);
        $mail2 = htmlspecialchars($_POST['mail2']);
        $mdp = Security::hacher($_POST['mdp']);
        $mdp2 = Security::hacher($_POST['mdp2']);
        $pseudolength = strlen($pseudo);
        if (!empty($pseudo) AND !empty($mail) AND !empty($mail2) AND !empty($mdp) AND !empty($mdp2)) {
            //verification des info
            if ($pseudolength <= 50) {
                    if($mail == $mail2){
                        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                            $testmail = ModelMembres::userexist($mail);
                            if($testmail == false){
                                if($mdp == $mdp2){
                                    $longueurKey = 12;
                                    $Key = "";
                                    for($i=1;$i<$longueurKey;$i++){
                                        $Key .= mt_rand(0,9);
                                    }
                                    $membre = new ModelMembres($pseudo,$mail,$mdp,$Key);
                                    $saveok = $membre->save();

                                    //envoie du mail 
                                    $header="MIME-Version: 1.0\r\n";
                                    $header.='From: "site.com"<lp.prioux@gmail.com>'."\n";
                                    $header.='Content-Type:text/html; cherset="uft_8"'."\n";
                                    $header.='Content-Transfert-Encoding: 8bit';
                                    $message = '<html>
                                    <body>
                                    <div align="centerr">
                                    <a href="http://localhost/ProjetPHP/index.php?controller=membre&action=confirmcompte&mailMembre='.urlencode($mail).'&confirmKey='.$Key.'">Confirmation de votre compte !</a>
                                    </div>
                                    </body>
                                    </hmtl>';

                                    mail($mail,"Confirmation de compte",$message,$header);
                                    header("Location: index.php?action=formlogin");
                                }else {
                                    echo "<p> Vos mot de passe ne corresponde pas ! </p>";
                                }
                            }else {
                                echo "<p> Adresse mail déjà utilisée ! </p>";
                            }
                        }else {
                            echo "<p> Votre adresse mail n'est pas valide ! </p>";
                        }
                    }else {
                        echo "<p> Vos adresse mail ne corresponde pas ! </p>";
                    }    
            } else {
                echo "<p> Votre pseudo doit contenir moins de 255 charactère ! </p>";
            }
        } else{ 
            echo '<p> Tous les champs doivent etre complété ! </p>';

        }
    }

    public static function formlogin() {
        $pagetitle = "Se connecter";
        $view = "login";
        require File::buildpath(array("view","view.php"));
    }

    public static function login(){
        ControllerMembre::formlogin();
        require_once File::buildpath(array('model','ModelMembres.php'));
        
        $mailconnect = $_POST['mailconnect'];
        $mdpconnect = $_POST['mdpconnect'];
        
        $membre = ModelMembres::verifMembre( $mailconnect, $mdpconnect);
        
        if (!is_string($membre)){
            if($membre->get("confirmCompte") == 1){
                $_SESSION['pseudoMembre'] = $membre->get("pseudoMembre");
                $_SESSION['mailMembre'] = $mailconnect;
                $_SESSION['numMembre'] = $membre->get("numMembre");
                $_SESSION['estadmin'] = $membre->get("estadmin");
                header("Location: index.php?action=profile");
                
            }
            else{
                echo "<p> Votre compte n'es toujours pas confirmer </p>";
            }
        }
        else{
            echo $membre;
        }
        
        
    }

    public static function confirmcompte(){
        if(isset($_GET['mailMembre'],$_GET['confirmKey']) AND !empty($_GET['mailMembre']) AND !empty($_GET['confirmKey'])){
            $mail= urldecode($_GET['mailMembre']);
            $key = $_GET['confirmKey'];
            
                if( ModelMembres::getwithmail($mail,'confirmCompte') == 0){
                    if(ModelMembres::getwithmail($mail,'confirmKey') == $key)
                        ModelMembres::compteconfirmer($mail,$key);
                    echo "<p>Votre compte a bien été confirmé !</p>";
                }else{
                    echo "<p>Votre compte a déja été confirmé !</p>";
                }
            }else{
                    echo "<p>l'utilisateur n'existe pas !</p>";
                }
    }
    

    public static function logout(){
    $_SESSION = array();
    session_destroy();
    header("Location: index.php?action=Home");
    }


    public static function profile(){
        $pagetitle = "Profil";
        $view = "Profile";
        require File::buildpath(array("view","view.php"));
        
    }

    public static function formediterprofile(){
        $pagetitle = "Editer Profil";
        $view = "update_create";
        $pseudoMembreHTML= $_SESSION['pseudoMembre'];
        $mailMembreHTML= $_SESSION['mailMembre'];
        $mdpMembreHTML= "";
        $primary_proprety = "readonly";
        $current_action = "edit";
        require File::buildpath(array("view","view.php"));
        /*
        $pagetitle = "Editer Profil";
        $view = "editerprofile";
        require File::buildpath(array("view","view.php"));*/
    }

    public static function editerprofile(){
        ControllerMembre::formediterprofile();
        $newpseudo = $_POST['pseudo'];
        //$newmail = $_POST['mail'];
        $newmdp1 = Security::hacher($_POST['mdp']);
        $newmdp2 = Security::hacher($_POST['mdp2']);
        
        
        if(isset($_SESSION['numMembre'])){
            if(isset($newpseudo) && $newpseudo != $_SESSION['pseudoMembre']){
                $array_pseudo=array("numMembre" => $_SESSION["numMembre"],"pseudoMembre" => $newpseudo,);
                ModelMembres::update($array_pseudo);
            }
            if(isset($newmail) && $newmail != $_SESSION['mailMembre'] && !ModelMembres::userexist($newmail)){
                $array_mail=array("numMembre" => $_SESSION["numMembre"],"mailMembre" => $newmail,);
                ModelMembres::update($array_mail);
            }
            if(isset($newmdp2) && isset($newmdp1) && $newmdp1 == $newmdp2){
                $array_mdp=array("numMembre" => $_SESSION["numMembre"],"mdpMembre" => $newmdp1,);
                ModelMembres::update($array_mdp);
            }
            header("Location: index.php?action=profile");
        }
        else {
            echo "<p> veuillez remplir au moins un champs ! </p>";
        }

    }
    public static function supprofile(){
        /*?>
        <script >
 
        if ( confirm( "Etes vous sûr de vouloir supprimer votre compte" ) ) {
            <?php*/
        ModelMembres::delete($_SESSION['numMembre']);
        ControllerMembre::logout();
        /*?>
        } else {
            <?php
        
        header("Location: index.php?action=profile");
        ?>
        }
        </script>
        <?php*/
    
    }

    public static function contact(){
        $pagetitle = "Contact";
        $view = "contact";
        require File::buildpath(array("view","view.php"));
    }

    //partie admin
    public static function Home2(){
        $view = "Homeadmin";
        $pagetitle = "Page d'acceuil";
        require File::buildpath(array("view","view2.php"));
    }
    
    
}
?>