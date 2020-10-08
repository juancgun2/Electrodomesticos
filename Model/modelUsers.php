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

}