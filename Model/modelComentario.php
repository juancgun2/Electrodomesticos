<?php 

class apiModelComentario{ 
    private $db;

    function __construct(){
        $this->db= new PDO('mysql:host=localhost;'.'dbname=electrodomesticos;charset=utf8', 'root', '');
    }

    function getComentarios(){
        $consulta=$this->db->prepare("SELECT * FROM comentario");
        $consulta->execute(array());
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    function getComentario($id){
        $consulta=$this->db->prepare("SELECT * FROM comentario WHERE idComentario=?");
        $consulta->execute(array($id));
        return $consulta->fetch(PDO::FETCH_OBJ);
    }

    function agregarComentario($descripcion,$idUsuario,$idProducto,$puntuacion){
        $consulta=$this->db->prepare("INSERT INTO comentario descripcion,idUsuario,idProducto,puntuacion
            VALUES(?,?,?,?)");
        $consulta->execute(array($descripcion,$idUsuario,$idProducto,$puntuacion));
        return $this->db->lastInsertId();
    }

    function eliminarComentario($id){
        $consulta=$this->db->prepare("DELETE FROM comentario WHERE idComentario=?");
        $consulta->execute(array($id));
        return $this->db->rowCount();
    }
}