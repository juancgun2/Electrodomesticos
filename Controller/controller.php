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
        $this->view->showDetalleItem($this->model->getItem($id_producto));
    } 

    function showCategorias(){ 
        $this->view->showCategorias($this->model->getCategorias());
    }

    function filtrarPorCategorias($params=null){ 
        $nombreCategoria=$params[":NOMBRE"];
        $id_categoria= $this->model->getIdCategoria($nombreCategoria); 
        $this->view->showAllItems($this->model->getItemsInOrder($id_categoria->id),$this->model->getCategorias());
    }
    //estas dos son muy parecidas. Revisar. La de abajo no muestra mostrarPorCategorias en nav.
    //la de arriba vuelve a home con productos filtrados por la categoria elegida.
    /*function productosPorCategoria($params=null){ 
        $nombreCategoria=$params[":CATEGORIA"]; 
        $idCategoria= $this->model->getIdCategoria($nombreCategoria);
        $productosFiltrados= $this->model->getItemsInOrder($idCategoria->id); 
        $this->view->showProductosPorCategoria($productosFiltrados); 
    }*/

    function insertarProducto(){ 
        if(!empty($_POST["nombre"])&&!empty($_POST["descripcion"])&&!empty($_POST["precio"])&&
            !empty($_POST["stock"])&&!empty($_POST["nameCategoria"])){ 
            $nombre=$_POST["nombre"]; 
            $descripcion=$_POST["descripcion"]; 
            $precio=$_POST["precio"]; 
            $stock=$_POST["stock"]; 
            $nombreCategoria=$_POST["nameCategoria"]; 
            if(!$this->existeProducto($nombre,$precio,$descripcion)){
                $id_categoria= $this->model->getIdCategoria($nombreCategoria);
                $this->model->insertarProducto($nombre,$descripcion,$precio,$stock,$id_categoria->id); 
            }else{ 
                $idProducto = $this->model->getIdProducto($nombre,$precio,$descripcion);
                $producto= $this->model->getItem($idProducto->id);
                $stock = $stock + $producto->stock;
                $this->model->setStock($idProducto->id,$stock);
            } 
            $this->view->home();          
        }else{ 
            $this->view->error(null,true,"home","");
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
            if(!$this->existeProducto($nombre,$precio,$descripcion)){
                $this->model->editarProducto($idProducto,$nombre,$descripcion,$precio,$stock,$idCategoria->id); 
                $this->view->home(); 
            }else{ 
                $error="El producto ingresado ya existe"; 
                $this->view->error($error,null,"formEditar/",$idProducto);
                // o le sumo el stock del nuevo al existente ?? 
            }                
        }else{ 
            $this->view->error(null,null,"formEditar/",$idProducto);
        }
    } 
    // revisar showFormEditarCategoria si se puede agregar a getIdCategoria que traiga el nombre tambien.
    // El problema seria que no retorne false cuando llame a existeCategoria.
    function showFormEditarCategoria($params=null){ 
        $nombreCategoria=$params[":NOMBRE"]; 
        $id_categoria=$this->model->getIdCategoria($nombreCategoria); 
        $this->view->showFormEditarCategoria($this->model->getCategoria($id_categoria->id));
    } 

    function editarCategoria(){ 
        $id_categoria=$_POST["id_categoria"];
        $nombreAnterior= $this->model->getCategoria($id_categoria);
        if(!empty($_POST["nombreCategoria"])){ 
            $nombreCategoria=$_POST["nombreCategoria"]; 
            if(!$this->existeCategoria($nombreCategoria)){
                $this->model->editarCategoria($id_categoria,$nombreCategoria); 
                $this->view->redirectionCategorias();
            }else{ 
                $error="La categoria ingresada ya existe";
                $this->view->error($error,true,"formEditarCategoria/",$nombreCategoria);
            }    

        }else{  
            $this->view->error(null,null,"formEditarCategoria/", $nombreAnterior->name);
        }
    } 

    function eliminarCategoria($params=null){ 
        $nombreCategoria=$params[":NOMBRE"]; 
        $id_categoria=$this->model->getIdCategoria($nombreCategoria); 
        //$this->view->alertDeleteCategoria($categoria->name);
        $this->model->eliminarCategoria($id_categoria->id); 
        $this->view->redirectionCategorias();
    }

    function existeProducto($nombre,$precio,$descripcion){ 
        $producto= $this->model->getIdProducto($nombre,$precio,$descripcion);
        if($producto===false){ 
            return false;
        }else{
            return true;
        }
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
            $nombre=$this->existeCategoria($_POST["nombreCategoria"]);
            if(!$this->existeCategoria($nombre){  
                $this->model->insertarCategoria($nombre); 
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