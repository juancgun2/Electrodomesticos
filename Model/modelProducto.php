<?php 

Class modelProducto{ 
    private $db;

    function __construct(){ 
        $this->db= new PDO('mysql:host=localhost;'.'dbname=electrodomesticos;charset=utf8', 'root', '');
    }  

    function getCantidad(){ 
        $consulta=$this->db->prepare("SELECT COUNT(producto.id) as cantidad from producto"); 
        $consulta->execute(); 
        return $consulta->fetch(PDO::FETCH_OBJ);
    }

    function getFiltrados($precioMin, $precioMax, $contador, $limit){ 
        $consulta = $this->db->prepare("SELECT producto.nombre,producto.precio,producto.stock,producto.id,
        categoria.name,producto.id_categoria from producto join categoria 
        on producto.id_categoria=categoria.id WHERE producto.precio BETWEEN :inicio AND :fin LIMIT :contador,:limite");
        $consulta->bindValue(':inicio', (int) $precioMin, PDO::PARAM_INT);
        $consulta->bindValue(':fin', (int) $precioMax, PDO::PARAM_INT);
        $consulta->bindValue(':contador', (int) $contador, PDO::PARAM_INT);
        $consulta->bindValue(':limite', (int) $limit, PDO::PARAM_INT);
        $consulta->execute(); 
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    function getProductosPaginados($contador,$cantidadProductos){ 
        $consulta = $this->db->prepare("SELECT producto.nombre,producto.precio,producto.stock,producto.id,
        categoria.name,producto.id_categoria from producto join categoria 
        on producto.id_categoria=categoria.id ORDER BY producto.nombre LIMIT :contador,:cantidadProductos"); 
        $consulta->bindValue(':contador', (int) $contador, PDO::PARAM_INT);
        $consulta->bindValue(':cantidadProductos', (int) $cantidadProductos, PDO::PARAM_INT);
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

    function getItemsInCategorias($id_categoria, $contador, $limit){ 
        $consulta=$this->db->prepare("SELECT p.id,p.nombre,p.descripcion,p.precio,p.stock,p.id_categoria,
        c.name from producto p JOIN categoria c WHERE p.id_categoria=:id and c.id=:id ORDER BY p.nombre LIMIT :contador,:limite"); 
        $consulta->bindValue(':id', (int) $id_categoria, PDO::PARAM_INT);
        $consulta->bindValue(':contador', (int) $contador, PDO::PARAM_INT);
        $consulta->bindValue(':limite', (int) $limit, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    } 

    function insertarProducto($nombre,$descripcion,$precio,$stock,$idCategoria){ 
        $consulta=$this->db->prepare("INSERT INTO producto(nombre,descripcion,precio,stock,id_categoria) 
                                        VALUES (?,?,?,?,?)"); 
        $consulta->execute(array($nombre,$descripcion,$precio,$stock,$idCategoria));
        return $this->db->lastInsertId();
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