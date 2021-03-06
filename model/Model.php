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

    public static function selectAll() {
        try {
            $pdo = self::$pdo;
            $tablename = static::$object;
            $classname = 'Model' . ucfirst(static::$object);
            $sql = "SELECT * from $tablename";
            $rep = $pdo->query($sql);
            $rep->setFetchMode(PDO::FETCH_CLASS, $classname);
            return $rep->fetchAll();
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
            } else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }
    
    
    public static function selectPrimary($primary_value){
        try {
            $pdo = self::$pdo;
            $table_name = static::$object;
            $class_name = "Model".ucfirst($table_name);
            $primary_key = static::$primary;
            $sql = "SELECT * from ".$table_name." WHERE ".$primary_key."=:nom_tag";
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                "nom_tag" => $primary_value,
            );
            // On donne les valeurs et on exécute la requête        
            $req_prep->execute($values);
            // On récupère les résultats comme précédemment
            $req_prep->setFetchMode(PDO::FETCH_CLASS, $class_name);
            $tab_object = $req_prep->fetchAll();
            // si il n'y a pas de résultats, on renvoie false
            if (empty($tab_object))
                return false;
            return $tab_object[0];
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
            } else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    } 

    public static function selectAllPrimary($primary_value){
        try {
            $pdo = self::$pdo;
            $table_name = static::$object;
            $class_name = "Model".ucfirst($table_name);
            $primary_key = static::$primary;
            $sql = "SELECT * from ".$table_name." WHERE ".$primary_key."=:nom_tag";
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                "nom_tag" => $primary_value,
            );
            // On donne les valeurs et on exécute la requête        
            $req_prep->execute($values);
            // On récupère les résultats comme précédemment
            $req_prep->setFetchMode(PDO::FETCH_CLASS, $class_name);
            $tab_object = $req_prep->fetchAll();
            // si il n'y a pas de résultats, on renvoie false
            if (empty($tab_object))
                return false;
            return $tab_object;
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
            } else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }
    
    public static function delete($deletevalue) {
        try {
            $table_name = static::$object;
            $primary_key = static::$primary;
            $sql = "DELETE FROM $table_name WHERE $primary_key=:primary;";
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                "primary" => $deletevalue
            );
            // On donne les valeurs et on exécute la requête	 
            return $req_prep->execute($values);
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
            } else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function update($data) {
        try {
            $table_name = static::$object;
            $primary_key = static::$primary;
            $set_parts = array();
            foreach ($data as $key => $value) {
                $set_parts[] = "$key=:$key";
            }
            $set_string = join(',', $set_parts);
            $sql = "UPDATE $table_name SET $set_string WHERE $primary_key=:$primary_key";
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);

            // On donne les valeurs et on exécute la requête	 
            return $req_prep->execute($data);
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
            } else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public function save() {
        try {
            $table_name = static::$object;
            
            // ReflectionClass ou écrire les attributs en dur
            $reflect = new ReflectionClass($this);
            $props = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
            
            $attributes = array();
            $data = array();
            
            foreach ($props as $prop) {
                $attributes[] = $prop->getName();
                $data[$prop->getName()] = $this->get($prop->getName());
            }
            $into_string = '(' . join(',',$attributes) . ')';
            
            // Rajoute ":" avant les attributs
            if($table_name!="livraison"){
            function my_prepend($s) { 
                return ":" . $s;                
            }
            }
            $values_string = '(' . join(',', array_map("my_prepend",$attributes)) . ')';            
            
            $sql = "INSERT INTO $table_name $into_string VALUES $values_string";
            
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);
            
            // On donne les valeurs et on exécute la requête	 
            return $req_prep->execute($data);
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                if ($e->errorInfo[1] == 1062) {
                    // Duplicate entry
                    return false;
                }
                echo $e->getMessage(); // affiche un message d'erreur
            } else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }
    
    
    
}
//Ceci est un test
Model::Init();
?>
