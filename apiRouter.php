<?php
require_once "RouterClass.php";
require_once "API/apiController.php";

$r = new router();

$r->addRoute("comentarios","GET","apiController","getComentarios"); 
$r->addRoute("comentario/:ID","GET","apiController","getComentario"); 
$r->addRoute("eliminarComentario/:ID","GET","apiController","eliminarComentario"); 
$r->addRoute("agregarComentario","GET","apiController","agregarComentario"); 

$r->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);