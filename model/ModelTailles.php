<?php
require_once File::buildpath(array("model","Model.php"));
class ModelTailles extends Model {
    protected static $object ="tailles";
    protected static $primary = "numProduit";
    private $numProduit;
    private $taille;
    private $stock;

    public function __construct($numProduit = NULL,$taille = NULL,$stock = NULL){
        if ( !is_null($numProduit) && !is_null($taille) && !is_null($stock)){
            $this->numProduit = $numProduit;
            $this->taille = $taille;
            $this->stock = $stock;
       }
    }
    
    public function get($nom_attribut) {
        if (property_exists($this, $nom_attribut))
            return $this->$nom_attribut;
        return false;
    }

}

?>