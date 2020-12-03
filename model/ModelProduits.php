<?php
require_once File::buildpath(array("model","Model.php"));
class ModelProduits extends Model {
    protected static $primary = "numProduit";
    protected static $object = "produits";
    private $numProduit;
    private $nomProduit;
    private $numCategorie;
    private $prix;
    private $descriptionProduit;
    private $img;

    public function __construct($nomProduit=NULL, $numCategorie=NULL,$prix=NULL,$descriptionProduit=NULL){
        if (!is_null($nomProduit) && !is_null($numCategorie) && !is_null($prix)  && !is_null($descriptionProduit)){

            $this->nomProduit=$nomProduit;
            $this->numCategorie=$numCategorie;
            $this->prix=$prix;
            $this->descriptionProduit=$descriptionProduit;
        }
    }
    public function set($nom_attribut,$valeur) {
        if(property_exists($this,$nom_attribut))
            $this->$nom_attribut = $valeur;
    }
    public function get($nom_attribut) {
        if (property_exists($this, $nom_attribut))
            return $this->$nom_attribut;
        return false;
    }
    public static function majimg($nump){
        
        $reqimg = Model::$pdo->prepare("SELECT imgPath FROM produits WHERE numProduit = ?");
        $reqimg->execute(array($nump));
        $img = $reqimg->fetch();
        return $img['imgPath'];
    }
    
}
?>