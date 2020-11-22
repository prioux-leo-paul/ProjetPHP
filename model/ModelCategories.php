<?php
require_once File::buildpath(array("model","Model.php"));
class ModelCategories extends Model {
    protected static $object = "Categories";
    protected static $primary = "numCategorie";
    private $numCategorie;
    private $nomCategorie;


    public function get($nom_attribut) {
        if (property_exists($this, $nom_attribut))
            return $this->$nom_attribut;
        return false;
    }
}
?>