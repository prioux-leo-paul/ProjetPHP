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

    public function __construct($nomProduit, $numCategorie,$prix,$stock,$tailleProduit,$descriptionProduit){
        $this->$nomProduit=$nomProduit;
        $this->$numCategorie=$numCategorie;
        $this->$prix=$prix;
        $this->$stock=$stock;
        $this->$tailleProduit=$tailleProduit;
        $this->$descriptionProduit=$descriptionProduit;
    }
    public function get($nom_attribut) {
        if (property_exists($this, $nom_attribut))
            return $this->$nom_attribut;
        return false;
    }
    
}
?>
