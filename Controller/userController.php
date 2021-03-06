<?php 
require_once "View/view.php";
require_once "Model/modelUsers.php";
require_once "Helper/helper.php";

class userController{ 
    private $modelUsers; 
    private $view;
    private $helper;

    function __construct(){ 
        $this->modelUsers= new modelUsers();
        $this->view = new view();
        $this->helper = new helper();
    }

    function crearCuenta() {
        if(!$this->helper->getRol()) {
            $email = $_POST["newEmail"];
            if(!$this->existeCuenta($email)) {
                $password = $_POST["newPassword"]; 
                $password = password_hash( $password, PASSWORD_DEFAULT); 
                $this->modelUsers->crearCuenta( $email, "user", $password);
                $this->helper->setSesion( $email, "user");
                $this->view->home();
            }else {
                $error= "El email ya existe, por favor inicie sesion";
                $this->view->showLogin(false,null,$error);
            }   
        } else 
            $this->helper->accesoDenegado();
    }

    private function existeCuenta($email){
        $cuenta = $this->modelUsers->getCuenta($email);
        if($cuenta === false)
            return false;
        else 
            return true;
    }
}