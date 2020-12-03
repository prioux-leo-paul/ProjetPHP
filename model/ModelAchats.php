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
          
            $this->dateAchat = date('Y-m-d',strtotime("now"));
            $this->taille = $taille;
        }
    }

    /*public function save() {
        try {
            $sql = "INSERT INTO achats ( numClient, numProduit, qteAchat, DateAchat,taille) VALUES (?,?,?,?,?)";
            
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);

            $values = array( $this->numClient, $this->numProduit, $this->qteAchat, $this->dateAchat, $this->taille);
            // On donne les valeurs et on exécute la requête	 
            $req_prep->execute($values);
            return true ;
            
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
            } else {
                $lien = File::buildpath(array("controller","routeur.php?action=formlogin"));
                echo "Votre compte a bien été creer ! <a href=\"".$lien."\">Me connecter</a>";
            }
            die();
        }
    }*/

    

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