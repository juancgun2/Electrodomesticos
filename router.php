<?php
require_once "Controller/controller.php";
require_once "RouterClass.php";

define("BASE_URL", 'http://'.$_SERVER["SERVER_NAME"].':'.$_SERVER["SERVER_PORT"].dirname($_SERVER["PHP_SELF"]).'/');

$r = new router();

$r->addRoute("home","GET","controller","Home"); 
$r->addRoute("verDetalle/:ID","GET","controller","showDetalleItem"); 
$r->addRoute("Categorias","GET","controller","showCategorias"); 
$r->addRoute("Categoria/:ID","GET","controller","categoriasInOrder"); 
$r->addRoute("insertProducto","POST","controller","insertarProducto"); 
$r->addRoute("eliminarProducto/:ID","GET","controller","eliminarProducto");
$r->addRoute("formEditar/:ID","GET","controller","showFormEditar");
$r->addRoute("editar","POST","controller","editarProducto");
$r->addRoute("editarCategoria","POST","controller","editarCategoria");
$r->addRoute("formEditarCategoria/:ID","GET","controller","showFormEditarCategoria");
//$r->addRoute("editar","POST","controller","editarProducto");
//$r->addRoute("editar","POST","controller","editarProducto");



$r->setDefaultRoute("controller","Home");

$r->route($_GET['action'], $_SERVER['REQUEST_METHOD']);