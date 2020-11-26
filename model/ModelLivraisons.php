<?php
require_once File::buildpath(array("model","Model.php"));
class ModelLivraisons extends Model{
    protected static $object = "livraison";
    protected static $primary = "numLivraison";
    private $numLivraison;
    private $numAchat;
    private $adresseLivraison;
    private $dateLivraison;

    public function __construct( $numAchat = NULL, $adresseLivraison = NULL, $dateLivraison = NULL){
        if (  !is_null($numAchat) && !is_null($adresseLivraison) && !is_null($dateLivraison)){

            $this->numAchat = $numAchat;
            $this->adresseLivraison = $adresseLivraison;
            $this->dateLivraison = $dateLivraison;
        }
    }

    public function get($nom_attribut) {
        if (property_exists($this, $nom_attribut))
            return $this->$nom_attribut;
        return false;
    }
    
    public static function selectbyachat($numachat){
        $reqliv = Model::$pdo->prepare("SELECT * FROM livraison WHERE numAchat = ?");
        $reqliv->execute(array($numachat));
        $liv = $reqliv->fetch();
        return $liv;
    }

}
?>