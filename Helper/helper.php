<?php 


class helper{ 
    private $view;
    private $modelUsers;

    function __construct(){
        $this->view = new view();
        $this->modelUsers = new modelUsers();
    }

    function getActivity(){
        if(!isset($_SESSION))
            session_start();  
        if(time()-$_SESSION["lastActivity"] > 999999) 
            return false;
        else {
            $this->setActivity();
            return true;
        }
    }

    function setSesion($email,$rol){
        $this->setEmail($email); 
        $this->setRol($rol);
        $this->setActivity();
    }

    private function setActivity(){
        if(!isset($_SESSION))
            session_start(); 
        $_SESSION["lastActivity"] = time();
    }

    function getRol(){ 
        if(!isset($_SESSION))
            session_start();
        if(empty($_SESSION["rol"]))
            return false;
        else 
           return $_SESSION["rol"];
    } 

    private function setRol($nombre=""){
        if(!isset($_SESSION))
            session_start();
        $_SESSION["rol"] = $nombre; 
    } 

    function cerrarSesion(){
        if(!isset($_SESSION))
            session_start();
        $_SESSION = array();
        session_destroy();
    }

    private function setEmail($email){
        if(!isset($_SESSION))
            session_start();
        $_SESSION["email"] = $email;
    }

    function getEmail(){
        if(!isset($_SESSION))
            session_start();
        if(empty($_SESSION["email"])) 
            return false;
        else 
            return $_SESSION["email"];
    }

    function getIdUsuario(){
        $idUser=$this->modelUsers->getIdUser($this->getEmail());
        return $idUser->id_login;
    }

    function caducoSesion() { 
        $this->cerrarSesion();
        $error= "La sesion caduco. Por favor inicie sesion nuevamente";
        $this->view->showLogin(false,null,$error);
    }

    function accesoDenegado() { 
        $this->cerrarSesion();
        $error= "Acceso denegado. Por favor inicie sesion";
        $this->view->showLogin(false,null,$error);
    }
}
