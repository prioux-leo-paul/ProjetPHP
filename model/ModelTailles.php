<?php
require_once File::buildpath(array("model","Model.php"));
class ModelTailles extends Model {
    protected static $object ="tailles";
    protected static $primary = "numProduit";
    private $numtaille;
    private $numProduit;
    private $taille;
    private $stock;

    public function __construct($numProduit = NULL,$taille = NULL,$stock = NULL){
        if (!is_null($numProduit) && !is_null($taille) && !is_null($stock)){
            $this->numProduit = $numProduit;
            $this->taille = $taille;
            $this->stock = $stock;
            if(!ModelTailles::tailleexist($numProduit,$taille)){
                $sql1 = "SELECT numtaille FROM tailles WHERE numProduit= ? AND taille = ?";
                // Préparation de la requête
                $req = Model::$pdo->prepare($sql1);
                $req->execute(array($this->numProduit,$this->taille));
                $numtaille = $req->fetch();
                $this->numtaille = $numtaille;
            }
       }
    }
    
    public function get($nom_attribut) {
        if (property_exists($this, $nom_attribut))
            return $this->$nom_attribut;
        return false;
    }

    public static function updatestock($new_stock,$nump,$taille){
        $sql1 = "SELECT stock FROM tailles WHERE numProduit= ? AND taille = ?";
            // Préparation de la requête
        $req = Model::$pdo->prepare($sql1);
        $req->execute(array($nump,$taille));
        $stock_actuel = $req->fetch();

        $stock = $stock_actuel['stock'] + $new_stock;
        $sql2 = "UPDATE tailles SET stock = ? WHERE numProduit= ? AND taille = ?";
            // Préparation de la requête
        $req_prep = Model::$pdo->prepare($sql2);
        $req_prep->execute(array($stock,$nump,$taille));
        
    }

    public function save() {
        try {
            $sql = "INSERT INTO tailles ( numProduit, taille, stock) VALUES (?,?,?)";
            
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);

            $values = array( $this->numProduit, $this->taille, $this->stock);
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
    }

    public static function tailleexist($nump,$taille){
        $reqliv = Model::$pdo->prepare("SELECT numtaille FROM tailles WHERE numProduit = ? AND taille = ?");
        $reqliv->execute(array($nump,$taille));
        $liv = $reqliv->rowCount();
        $liv2 = $reqliv->fetch();
        if($liv == 0)
            return false;
        else 
            return $liv2;
    }

    public static function supprimertaille($param){
        if(isset($_SESSION['estadmin'])){
            if($_SESSION['estadmin'] == 1){
                $req = Model::$pdo->prepare("DELETE FROM tailles WHERE numtaille = ?");
                $req->execute(array($param));
            }
        }
    }
    public static function updatestock2($new_stock,$nump,$taille){
        $sql2 = "UPDATE tailles SET stock = ? WHERE numProduit= ? AND taille = ?";
            // Préparation de la requête
        $req_prep = Model::$pdo->prepare($sql2);
        $req_prep->execute(array($new_stock,$nump,$taille));
        
    }

    

}

?>