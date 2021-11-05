<?php

Class modelCategorias{ 
    private $db;

    function __construct(){ 
        $this->db= new PDO('mysql:host=dbService;'.'dbname=electrodomesticos','root','password');
    } 

    function getCategorias(){ 
        $consulta=$this->db->prepare("SELECT categoria.name,categoria.id from categoria ORDER BY categoria.name"); 
        $consulta->execute(); 
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    function getIdCategoria($nombreCategoria){ 
        $consulta=$this->db->prepare("SELECT id from categoria WHERE name=? "); 
        $consulta->execute(array($nombreCategoria)); 
        return $consulta->fetch(PDO::FETCH_OBJ);
    }

    function getCategoria($idCategoria){ 
        $consulta=$this->db->prepare("SELECT name,id from categoria where id=?"); 
        $consulta->execute(array($idCategoria));
        return $consulta->fetch(PDO::FETCH_OBJ);

    }

    function editarCategoria($id_categoria,$nombre){ 
        $consulta=$this->db->prepare("UPDATE categoria SET categoria.name=? WHERE id=?"); 
        $consulta->execute(array($nombre,$id_categoria)); 
    } 

    function insertarCategoria($nombre){ 
        $consulta=$this->db->prepare("INSERT INTO categoria(name) VALUES(?)"); 
        $consulta->execute(array($nombre));
    } 

    function eliminarCategoria($id_categoria){ 
        $consulta=$this->db->prepare("DELETE from categoria WHERE id=?"); 
        $consulta->execute(array($id_categoria));
    } 
}
