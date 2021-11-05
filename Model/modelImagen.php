<?php 

Class modelImagen{ 
    private $db;

    function __construct(){ 
        $this->db= new PDO('mysql:host=dbService;'.'dbname=electrodomesticos','root','password');
    } 

    function insertarImagen($idProducto,$ruta){ 
        $consulta=$this->db->prepare("INSERT INTO imagen(id_producto,path) VALUES (?,?)"); 
        $consulta->execute(array($idProducto,$ruta));
    }

    function getImagenes($idProducto){ 
        $consulta=$this->db->prepare("SELECT id_imagen,path FROM imagen WHERE id_producto=?"); 
        $consulta->execute(array($idProducto));
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    function eliminarImagen($idImagen){ 
        $consulta=$this->db->prepare("DELETE FROM imagen WHERE id_imagen=?"); 
        $consulta->execute(array($idImagen));
    }

    function getPathImagen($idProducto){ 
        $consulta=$this->db->prepare("SELECT path FROM imagen WHERE id_producto=? LIMIT 1"); 
        $consulta->execute(array($idProducto));
        return $consulta->fetch(PDO::FETCH_OBJ);
    }
}