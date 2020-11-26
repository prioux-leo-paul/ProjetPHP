<?php
require_once File::buildpath(array("model","Model.php"));
class ModelAchats {
    protected static $object = "achat";
    private $numClient;
    private $numProduit;
    private $qteAchat;
    private $ateAchat; 

    public function __construct($numClient, $numProduit, $qteAchat){
        if ( !is_null($numClient) && !is_null($numProduit)&& !is_null($qteAchat)){
            $this->numClient = $numClient;
            $this->numProduit = $numProduit;
            $this->qteAchat = $qteAchat;
            $this->dateAchat = getdate();
        }
    }

    

}
?>