<?php
require_once File::buildpath(array("controller","ControllerMembre.php"));
// On recupère l'action passée dans l'URL
$action = isset($_GET['action']) ? $_GET['action'] : 'Home';
// Appel de la méthode statique $action de ControllerVoiture
ControllerMembre::$action();
?>

