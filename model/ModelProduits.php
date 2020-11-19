<?php
require_once File::buildpath(array("model","Model.php"));
class ModelProduits extends Model {
    protected static $primary = "numProduit";
    protected static $object = "PRODUITS";
    private $numProduit;
    private $nomProduit;
    private $numCategorie;
    private $prix;
    private $stock;
    private $tailleProduit;
    private $descriptionProduit;

    public function __construct($numProduit = NULL,$nomProduit=NULL, $numCategorie=NULL,$prix=NULL,$stock=NULL,$tailleProduit=NULL,$descriptionProduit=NULL){
        if (!is_null($numProduit) && !is_null($nomProduit) && !is_null($numCategorie) && !is_null($prix) && !is_null($stock) && !is_null($tailleProduit) && !is_null($descriptionProduit)){
            $this->$numProduit=$numProduit;
            $this->$nomProduit=$nomProduit;
            $this->$numCategorie=$numCategorie;
            $this->$prix=$prix;
            $this->$stock=$stock;
            $this->$tailleProduit=$tailleProduit;
            $this->$descriptionProduit=$descriptionProduit;
        }
    }
    public function get($nom_attribut) {
        if (property_exists($this, $nom_attribut))
            return $this->$nom_attribut;
        return false;
    }
    
}
?>
