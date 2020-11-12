<?php

// On recupère l'action passée dans l'URL
$action = isset($_GET['action']) ? $_GET['action'] : "Home";
$controller = isset($_GET['controller']) ? $_GET['controller'] : "membre";
$controller_class = "Controller".ucfirst($controller);

if (class_exists($controller_class)){
    require_once File::buildpath(array("Controller",$controller_class .".php"));
    $controller_class::$action();
}else{
// Appel de la méthode statique $action de ControllerVoiture
require_once File::buildpath(array("Controller","ControllerMembre.php"));
ControllerMembre::Home(); 
}?>

