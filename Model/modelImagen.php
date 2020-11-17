<?php 

Class modelImagen{ 
    private $db;

    function __construct(){ 
        $this->db= new PDO('mysql:host=localhost;'.'dbname=electrodomesticos;charset=utf8', 'root', '');
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
}