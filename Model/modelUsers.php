<?php 

class modelUsers{ 
    private $db;

    function __construct(){ 
        $this->db= new PDO('mysql:host=localhost;'.'dbname=electrodomesticos;charset=utf8', 'root', '');
    } 

    function getPassword($email){ 
            $consulta=$this->db->prepare("SELECT password FROM login WHERE email=?"); 
            $consulta->execute(array($email)); 
            return $consulta->fetch(PDO::FETCH_OBJ);
    }

    function crearCuenta($email,$password){
        $consulta=$this->db->prepare("INSERT into login (email,password) values(?,?)");
        $consulta->execute(array($email,$password));
    }

    function existeCuenta($email){ 
        $consulta= $this->db->prepare("SELECT email FROM login WHERE email=?");
        $consulta->execute(array($email));
        return $consulta->fetch(PDO::FETCH_OBJ);
    }

}