<?php

require_once File::buildpath(array("controller","ControllerMembre.php"));
require_once File::buildpath(array("controller","ControllerAchat.php"));

$action = isset($_GET['action']) ?  $_GET['action'] : "Home";
$controller = isset($_GET['controller']) ? $_GET['controller'] : "membre";
$controller_class = "Controller".ucfirst($controller);
if (class_exists($controller_class) && in_array($action, get_class_methods($controller_class))) {
    $controller_class::$action();
} else {
    ControllerMembre::Error();
}
?>

