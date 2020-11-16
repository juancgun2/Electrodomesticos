<?php

require_once "RouterClass.php";
require_once "./API/apiController.php";



$r = new router();

$r->addRoute("comentarios","GET","apiController","getAllComentarios"); 
$r->addRoute("comentarios/:ID","GET","apiController","getByIdProducto"); 
$r->addRoute("comentarios/:ID","DELETE","apiController","eliminarComentario"); 
$r->addRoute("comentarios","POST","apiController","agregarComentario"); 


$r->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);