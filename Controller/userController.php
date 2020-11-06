<?php 
require_once "View/view.php";
require_once "Model/modelUsers.php";

class userController{ 
    private $modelUsers; 
    private $view;
    private $helper;

    function __construct(){ 
        $this->modelUsers= new modelUsers();
        $this->view = new view();
        $this->helper = new helper();
    }

    function crearCuenta(){
        $email = $_POST["newEmail"];
        if(!$this->existeCuenta($email)){
            $password=$_POST["newPassword"]; 
            $password= password_hash($password,PASSWORD_DEFAULT); 
            $this->modelUsers->crearCuenta($email,"user",$password);
            $this->helper->setRol("user");
            $this->helper->setEmail($email);
            $this->view->home();
        }else {
            //si la contraseña es correcta inicia sesion
            $cuenta= $this->modelUsers->getCuenta($email);
            $password=$_POST["newPassword"];
            if(password_verify($paswword,$cuenta->password))
                $this->view->home();
            else
                $this->view->showLogin();//preguntar
        }
    }

    function existeCuenta($email){
        $cuenta=$this->modelUsers->getCuenta($email);
        if($cuenta===false){
            return false;
        }else {
            return true;
        }
    }

    function eliminarUsuario($params=null){
        $idUsuario=$params[":ID"];
        $this->modelUsers->eliminarUsuario($idUsuario);
        $this->view->home("Usuarios");
    }
}