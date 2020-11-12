<?php
    require_once __DIR__ . DIRECTORY_SEPARATOR . "lib". DIRECTORY_SEPARATOR ."File.php";
    require_once ("model/Model.php");
    $requser = Model::$pdo->prepare("SELECT * FROM MEMBRES");
    $requser->execute();
    $userexist = $requser->rowCount();

    echo $userexist;
?>