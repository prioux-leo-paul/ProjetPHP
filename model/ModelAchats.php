<?php
require_once File::buildpath(array("model","Model.php"));
class ModelAchats extends Model {
    protected static $object = "achats";
    protected static $primary = "numAchat";
    private $numAchat;
    private $numClient;
    private $numProduit;
    private $qteAchat;
    private $dateAchat; 
    private $taille;

    public function __construct($numClient = NULL, $numProduit = NULL, $qteAchat = NULL, $taille = NULL){
        if ( !is_null($numClient) && !is_null($numProduit) && !is_null($qteAchat) && !is_null($taille)){
            $this->numClient = $numClient;
            $this->numProduit = $numProduit;
            $this->qteAchat = $qteAchat;
            $this->dateAchat = getdate();
            $this->taille = $taille;
        }
    }

    public function get($nom_attribut) {
        if (property_exists($this, $nom_attribut))
            return $this->$nom_attribut;
        return false;
    }

    public static function selectallbyclient($nummembre){
        $reqachat = Model::$pdo->prepare("SELECT * FROM achats WHERE numClient = ?");
        $reqachat->execute(array($nummembre));
        $tabachatclient = $reqachat->fetchAll();
        return $tabachatclient;
    }

    public static function nbrachatsclient($nummembre){
        $reqachat = Model::$pdo->prepare("SELECT * FROM achats WHERE numClient = ?");
        $reqachat->execute(array($nummembre));
        $tabachatclient = $reqachat->rowCount();
        return $tabachatclient;
    }

    public function majnumachat(){
        $reqachat = Model::$pdo->prepare("SELECT numAchat FROM achats WHERE numClient = ? AND numProduit = ? AND qteAchat = ? AND DateAchat = ? AND taille = ?");
        $reqachat->execute(array($this->numClient,$this->numProduit,$this->qteAchat,$this->dateAchat,$this->taille));
        $achat = $reqachat->fetch();
        $this->numAchat = $achat['numAchat'];
        
    }

    

}
?>