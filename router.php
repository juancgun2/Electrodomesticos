<?php
require_once "Controller/controller.php";
require_once "Controller/adminController.php";
require_once "Controller/userController.php";
require_once "Controller/authController.php";
require_once "RouterClass.php";

define("BASE_URL", 'http://'.$_SERVER["SERVER_NAME"].':'.$_SERVER["SERVER_PORT"].dirname($_SERVER["PHP_SELF"]).'/');

$r = new router();

$r->addRoute("home", "GET", "controller", "getPaginados"); 
            /*
                Productos
            */
$r->addRoute("verDetalle/:ID", "GET", "controller", "showDetalleItem"); 
$r->addRoute("insertProducto", "POST", "adminController", "insertarProducto"); 
$r->addRoute("eliminarProducto/:ID", "GET", "adminController", "eliminarProducto");
$r->addRoute("formEditar/:ID", "GET", "adminController", "showFormEditar");
$r->addRoute("editar", "POST", "adminController", "editarProducto");
$r->addRoute("filtrados", "POST", "controller", "filtroAvanzado");
            /*
                Categorias 
            */
$r->addRoute("Categorias", "GET", "controller", "showCategorias"); 
$r->addRoute("Categoria/:NOMBRE","GET","controller","filtrarPorCategorias"); 
$r->addRoute("editarCategoria", "POST", "adminController", "editarCategoria");
$r->addRoute("formEditarCategoria/:NOMBRE", "GET", "adminController", "showFormEditarCategoria");
$r->addRoute("eliminarCategoria/:NOMBRE", "GET", "adminController", "eliminarCategoria");
$r->addRoute("insertCategoria", "POST", "adminController", "insertarCategoria");
            /*
                Usuarios  
            */
$r->addRoute("showLogin", "GET", "controller", "showLogin");
$r->addRoute("iniciarSesion", "POST", "authController", "iniciarSesion"); 
$r->addRoute("cerrarSesion", "GET", "authController", "exit");
$r->addRoute("registrarse", "POST", "userController", "crearCuenta"); 
$r->addRoute("Usuarios","GET","adminController","showUsuarios"); 
$r->addRoute("eliminarUsuario/:ID","GET","adminController","eliminarUsuario"); 
$r->addRoute("setAdmin/:ID","GET","adminController","setAdmin"); 
$r->addRoute("setUsuario/:ID","GET","adminController","setUser"); 
            /* 
                Imagenes
            */
$r->addRoute("eliminarImagen/:ID","GET","adminController","eliminarImagen"); 


$r->setDefaultRoute("controller","getPaginados");

$r->route($_GET['action'], $_SERVER['REQUEST_METHOD']);