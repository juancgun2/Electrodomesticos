<?php 
require_once "./View/view.php"; 
require_once "./Model/model.php";

Class controller{ 
    private $model; 
    private $view;

    function __construct(){ 
        $this->model = new model(); 
        $this->view= new view();
    } 

    function Home(){ 
        $this->view->showAllItems($this->model->getAllItems(),$this->model->getCategorias());
    } 

    function showDetalleItem($params=null){ 
        $id_producto=$params[':ID'];   
        //$producto=$this->model->getItem($id_producto); 
        //print_r($producto); 
        //die();
        $this->view->showDetalleItem($this->model->getItem($id_producto));
    } 

    function showCategorias(){ 
        $this->view->showCategorias($this->model->getCategorias());
    }

    function categoriasInOrder($params=null){ 
        $id_categoria=$params[":ID"]; 
        $this->view->showAllItems($this->model->getItemsInOrder($id_categoria),$this->model->getCategorias());
    }

    function insertarProducto(){ 
        if(!empty($_POST["nombre"])&&!empty($_POST["descripcion"])&&!empty($_POST["precio"])&&
            !empty($_POST["stock"])&&!empty($_POST["nameCategoria"])){ 
            $nombre=$_POST["nombre"]; 
            $descripcion=$_POST["descripcion"]; 
            $precio=$_POST["precio"]; 
            $stock=$_POST["stock"]; 
            $nombreCategoria=$_POST["nameCategoria"]; 
            $id_categoria= $this->model->getIdCategoria($nombreCategoria);
            $this->model->insertarProducto($nombre,$descripcion,$precio,$stock,$id_categoria->id);
            $this->view->home();       
        }else{ 
            $error="Por favor complete todos los campos";
            $this->view->error($error);
        } 
    } 

    function eliminarProducto($params=null){ 
        $id_producto=$params[":ID"]; 
        $this->model->eliminarProducto($id_producto);
        $this->view->home();
    }

    function showFormEditar($params=null){ 
        $id_producto=$params[":ID"]; 
        $categorias=$this->model->getCategorias(); 
        $producto=$this->model->getItem($id_producto);
        $this->view->showFormEditar($id_producto,$categorias,$producto);
    }

    function editarProducto(){ 
        if(!empty($_POST["id_producto"])&&!empty($_POST["nombre"])&&!empty($_POST["descripcion"])
            &&!empty($_POST["precio"])&&!empty($_POST["stock"])&&!empty($_POST["nameCategoria"])){     
            $nombre=$_POST["nombre"]; 
            $descripcion=$_POST["descripcion"]; 
            $precio=$_POST["precio"];
            $stock=$_POST["stock"];
            $nombreCategoria=$_POST["nameCategoria"]; 
            $idProducto=$_POST["id_producto"];
            $idCategoria= $this->model->getIdCategoria($nombreCategoria);
            $this->model->editarProducto($idProducto,$nombre,$descripcion,$precio,$stock,$idCategoria->id); 
            $this->view->home(); 
        }else{ 
            $error="Por favor complete todos los campos";
            $this->view->error($error);
        }
    }
}