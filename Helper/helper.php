<?php 
require_once "./Model/model.php";

class helper{ 

    function getActivity(){
        if(!isset($_SESSION))
            session_start();  
        if(time()-$_SESSION["lastActivity"] > 120) {
            return false;
        }else{
            return true;
        }
    }

    function setActivity(){ 
        if(!isset($_SESSION))
            session_start(); 
        $_SESSION["lastActivity"]= time();
    }

    function setNullActivity(){ 
        if(!isset($_SESSION))
            session_start(); 
        $_SESSION["lastActivity"]= "";
    }

    function getSesion(){ 
        if(!isset($_SESSION))
            session_start();
        if(empty($_SESSION["nombre"])){ 
            return false;
        }else{ 
            return true;
        }
    } 

    function setSesion($nombre=""){
        if(!isset($_SESSION))
            session_start();
        $_SESSION["nombre"]=$nombre; 
    } 

    function cerrarSesion(){
        $this->setNullActivity();
        $this->setSesion();
     }
}
