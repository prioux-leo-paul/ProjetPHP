<?php
class File{
    public static function buildpath($path_array) {
    $DS = DIRECTORY_SEPARATOR;
    $ROOT_FOLDER = __DIR__ . $DS . "..";
    return $ROOT_FOLDER . $DS . join($DS, $path_array);
}
}
?>