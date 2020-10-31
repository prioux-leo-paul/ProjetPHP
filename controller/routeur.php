<?php
require_once File::buildpath(array("controller","ControllerMembre.php"));
// On recupère l'action passée dans l'URL
$action = $_GET['action'];
// Appel de la méthode statique $action de ControllerVoiture
ControllerMembre::$action(); 
?>

