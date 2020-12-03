<?php
if(!isset($_SESSION['numMembre']) AND isset($_COOKIE['mailMembre'],$_COOKIE['mdpMembre']) AND !empty($_COOKIE['mailMembre']) AND !empty($_COOKIE['mdpMembre'])){
        
    $membre = ModelMembres::verifMembre( $_COOKIE['mailMembre'],$_COOKIE['mdpMembre']);
        
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
?>