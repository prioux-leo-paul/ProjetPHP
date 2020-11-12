<?php


require_once File::buildpath(array("config","Conf.php"));

class Model {
    
    static public $pdo;
    
    public static function Init(){
        $hostname = Conf::getHostname();
        $database_name = Conf::getDatabase();
        $login = Conf::getLogin();
        $password = Conf::getPassword();
        try {
            self::$pdo = new PDO("mysql:host=$hostname;dbname=$database_name", $login, $password,
                     array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));   
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        

        } catch(PDOException $e) {
            if (Conf::getDebug()){
                echo $e->getMessage();
            } else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function selectAll(){
        $table_name = static::$object;
        $class_name = 'Model'.ucfirst($table_name);
        $sql = 'SELECT * FROM '.$table_name;
        $rep = Model::$pdo->query($sql);
        $rep->setFetchMode(Model::$pdo::FETCH_CLASS, $class_name);
        $tab = $rep->fetchAll();
        return $tab;
      }
    
    
}
//Ceci est un test
Model::Init();
?>
