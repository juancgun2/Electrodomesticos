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
            $this->view->error();
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
        $idProducto=$_POST["id_producto"];
        if(!empty($_POST["nombre"])&&!empty($_POST["descripcion"])
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
            $this->view->error(null,null,"formEditar/",$idProducto);
        }
    } 

    function showFormEditarCategoria($params=null){ 
        $id_categoria=$params[":ID"]; 
        $categoria=$this->model->getCategoria($id_categoria); 
        $this->view->showFormEditarCategoria($categoria);
    } 

    function editarCategoria(){ 
        $id_categoria=$_POST["id_categoria"];
        if(!empty($_POST["nombreCategoria"])){ 
            $nombreCategoria=$_POST["nombreCategoria"]; 
            $this->model->editarCategoria($id_categoria,$nombreCategoria); 
            $this->view->redirectionCategorias();

        } else {  
            $this->view->error(null,null,"formEditarCategoria/",$id_categoria);
        }
    } 

    function eliminarCategoria($params=null){ 
        $id_categoria=$params[":ID"]; 
        $categoria=$this->model->getCategoria($id_categoria); 
        //$this->view->alertDeleteCategoria($categoria->name);
        $this->model->eliminarCategoria($id_categoria); 
        $this->view->redirectionCategorias();
    }

    function existeCategoria($nombre){ 
        $idCategoria=$this->model->getIdCategoria($nombre); 
        if($idCategoria===false){ 
            return false;
        } else{ 
            return true;
        }
    }

    function insertarCategoria(){ 
        if(!empty($_POST["nombreCategoria"])){
            $nose=$this->existeCategoria($_POST["nombreCategoria"]);
            if(!$this->existeCategoria($_POST["nombreCategoria"])){  
                $this->model->insertarCategoria($_POST["nombreCategoria"]); 
                $this->view->redirectionCategorias();
            }else{ 
                $error="La categoria ingresada ya existe";
                $this->view->error($error,true,null,null);
            }
            
        } else { 
            $this->view->error(null,true,null,null);
        }
    }
}