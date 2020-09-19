<?php 

Class model{ 
    private $db;

    function __construct(){ 
        $this->db= new PDO('mysql:host=localhost;'.'dbname=electrodomesticos;charset=utf8', 'root', '');
    } 

    function getAllItems(){ 
        $consulta=$this->db->prepare("SELECT producto.nombre,producto.precio,producto.stock,producto.id,
        categoria.name,producto.id_categoria from producto join categoria on producto.id_categoria=categoria.id"); 
        $consulta->execute(); 
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    } 

    function getItem($id_producto){ 
        $consulta=$this->db->prepare("SELECT * from producto join categoria on producto.id_categoria=categoria.id
        WHERE producto.id=?");
        $consulta->execute(array($id_producto)); 
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    function getCategorias(){ 
        $consulta=$this->db->prepare("SELECT categoria.name,categoria.id from categoria "); 
        $consulta->execute(); 
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    function getItemsInOrder($id_categoria){ 
        $consulta=$this->db->prepare("SELECT producto.nombre,producto.precio,producto.stock,categoria.name,
        producto.id,producto.id_categoria from producto join categoria 
        WHERE producto.id_categoria=categoria.id ORDER BY producto.id_categoria=? DESC"); 
        $consulta->execute(array($id_categoria)); 
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }



}