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

    function getCategorias(){ 
        $consulta=$this->db->prepare("SELECT categoria.name,categoria.id from categoria ORDER BY categoria.name"); 
        $consulta->execute(); 
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    function getIdCategoria($nombreCategoria){ 
        $consulta=$this->db->prepare("SELECT id,name from categoria WHERE name=? "); 
        $consulta->execute(array($nombreCategoria)); 
        return $consulta->fetch(PDO::FETCH_OBJ);
    }

    function getItemsInOrder($id_categoria){ 
        $consulta=$this->db->prepare("SELECT * from producto JOIN categoria WHERE producto.id_categoria=? 
            and categoria.id=? ORDER BY producto.nombre"); 
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
    } 

    function editarCategoria($id_categoria,$nombre){ 
        $consulta=$this->db->prepare("UPDATE categoria SET name=? WHERE id=?"); 
        $consulta->execute(array($id_categoria,$nombre)); 
    } 

    function insertarCategoria($nombre){ 
        $consulta=$this->db->prepare("INSERT INTO categoria(nombre) VALUES(?)"); 
        $consulta->execute(array($nombre));
    } 

    function eliminarCategoria($id_categoria){ 
        $consulta=$this->db->prepare("DELETE categoria WHERE id=?"); 
        $consulta->execute(array($id_categoria));
    }