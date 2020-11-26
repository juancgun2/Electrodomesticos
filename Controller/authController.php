<?php 
require_once "./View/view.php"; 
require_once "./Helper/helper.php";
require_once "./Model/modelUsers.php";

Class authController{ 
    private $modelUsers;
    private $view;
    private $helper;

    function __construct(){ 
        $this->modelUsers = new modelUsers(); 
        $this->view = new view();
        $this->helper = new helper();
    }

    function iniciarSesion(){ 
        if(!empty($_POST["email"]) && !empty($_POST["password"])){
            $cuenta = $this->modelUsers->getCuenta($_POST["email"]);
            if($cuenta != false && password_verify($_POST["password"], $cuenta->password)){ 
                $this->helper->setSesion($cuenta->email, $cuenta->permisos);
                $this->view->home();
            } else { 
                $error= "Usuario o contraseña incorrecto";
                $this->view->showLogin(false,null,$error);
            }
        } else { 
            $error= "Por favor complete todos los campos";
            $this->view->showLogin(false,null,$error);
        }
    }

    function exit(){ 
        $this->helper->cerrarSesion(); 
        $this->view->home();
    }
}