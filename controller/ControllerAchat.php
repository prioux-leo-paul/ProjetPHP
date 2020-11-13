<?php
require_once File::buildpath(array("model","ModelAchats.php")); // chargement du modèle

class ControllerAchat {

    public static function commander() {
        if("voir si le stock est suffisant"){
            $achat = new ModelAchats(array("numClient"=>$_GET['numClient'],"numProduit"=>$_GET['numProduit'],"qteAchat"=>$_GET['qteAchat']));
                            $saveok = $achat->save();
                            
        }
    }
}

?>