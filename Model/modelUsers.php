<?php 

class modelUsers{ 
    private $db;

    function __construct(){ 
        $this->db= new PDO('mysql:host=dbService;'.'dbname=electrodomesticos','root','password');
    } 

    function getPassword($email){ 
        $consulta=$this->db->prepare("SELECT password FROM login WHERE email=?"); 
        $consulta->execute(array($email)); 
        return $consulta->fetch(PDO::FETCH_OBJ);
    }

    function getIdUser($email){
        $consulta=$this->db->prepare("SELECT id_login FROM login WHERE email=?"); 
        $consulta->execute(array($email)); 
        return $consulta->fetch(PDO::FETCH_OBJ);
    }

    function crearCuenta($email,$permisos,$password){
        $consulta=$this->db->prepare("INSERT into login (email,permisos,password) values(?,?,?)");
        $consulta->execute(array($email,$permisos,$password));
    }

    function getCuenta($email){
        $consulta= $this->db->prepare("SELECT * FROM login WHERE email=?");
        $consulta->execute(array($email));
        return $consulta->fetch(PDO::FETCH_OBJ);
    }

    function getPermisos($email){ 
        $consulta= $this->db->prepare("SELECT permisos FROM login WHERE email=?");
        $consulta->execute(array($email));
        return $consulta->fetch(PDO::FETCH_OBJ);
    }

    function getUsuarios(){
        $consulta= $this->db->prepare("SELECT id_login,email,permisos FROM login");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    function eliminarUsuario($id){
        $consulta=$this->db->prepare("DELETE from login WHERE id_login=?"); 
        $consulta->execute(array($id)); 
    }

    function setAdmin($id){
        $consulta=$this->db->prepare("UPDATE login SET permisos=? WHERE id_login=?");
        $consulta->execute(array("admin",$id));
    }

    function setUser($id){
        $consulta=$this->db->prepare("UPDATE login SET permisos=? WHERE id_login=?");
        $consulta->execute(array("user",$id));
    }

}