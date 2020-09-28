<?php 

Class model{ 
    private $db;

    function __construct(){ 
        $this->db= new PDO('mysql:host=localhost;'.'dbname=electrodomesticos;charset=utf8', 'root', '');
    } 

    function getAllItems(){ 
        $consulta=$this->db->prepare("SELECT producto.nombre,producto.precio,producto.stock,producto.id,
        categoria.name,producto.id_categoria from producto join categoria 
        on producto.id_categoria=categoria.id ORDER BY producto.nombre"); 
        $consulta->execute(); 
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    } 

    function getItem($id_producto){ 
        $consulta=$this->db->prepare("SELECT producto.nombre,producto.precio,producto.stock,producto.id,
        categoria.name,producto.descripcion from producto join categoria on producto.id_categoria=categoria.id
        WHERE producto.id=?");
        $consulta->execute(array($id_producto)); 
        return $consulta->fetch(PDO::FETCH_OBJ);
    }

    function getIdProducto($nombre,$precio,$descripcion,$idCategoria){ 
        $consulta=$this->db->prepare("SELECT id FROM producto WHERE nombre=? and precio=? 
        and descripcion=? and id_categoria=?");
        $consulta->execute(array($nombre,$precio,$descripcion,$idCategoria));
        return $consulta->fetch(PDO::FETCH_OBJ);
    }

    function setStock($id,$stock){ 
        $consulta=$this->db->prepare("UPDATE producto SET stock=? WHERE id=?"); 
        $consulta->execute(array($stock,$id));
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

    function getItemsInOrder($id_categoria){ 
        $consulta=$this->db->prepare("SELECT p.id,p.nombre,p.descripcion,p.precio,p.stock,p.id_categoria,
        c.name from producto p JOIN categoria c WHERE p.id_categoria=? and c.id=? ORDER BY p.nombre"); 
        $consulta->execute(array($id_categoria,$id_categoria)); 
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    } 

    function insertarProducto($nombre,$descripcion,$precio,$stock,$idCategoria){ 
        $consulta=$this->db->prepare("INSERT INTO producto(nombre,descripcion,precio,stock,id_categoria) 
        VALUES (?,?,?,?,?)"); 
        $consulta->execute(array($nombre,$descripcion,$precio,$stock,$idCategoria));
    }

    function eliminarProducto($id_producto){ 
        $consulta=$this->db->prepare("DELETE from producto WHERE id=?");
        $consulta->execute(array($id_producto));
    } 

    function editarProducto($idProducto,$nombre,$descripcion,$precio,$stock,$idCategoria){ 
        $consulta=$this->db->prepare("UPDATE producto SET nombre=?,descripcion=?,precio=?,stock=?,
        id_categoria=? WHERE producto.id=?"); 
        $consulta->execute(array($nombre,$descripcion,$precio,$stock,$idCategoria,$idProducto));
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