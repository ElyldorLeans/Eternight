<?php

define("projectPath", $_SERVER['DOCUMENT_ROOT'] . "/Eternight/");

/**
 * importe automatiquement les classes inconnues si elles existent
 * @param string $name le nom de la classe
 * @throws Exception
 */
function __autoload($name){
    require_once(projectPath . "class/" .$name. ".class.php");
}