<?php 
require_once "./View/view.php"; 
require_once "./Model/model.php"; 
require_once "./Helper/helper.php";

Class adminController{ 
    private $model; 
    private $view;
    private $helper;

    function __construct(){ 
        $this->model = new model(); 
        $this->view= new view();
        $this->helper = new helper();
    } 

    function insertarProducto(){ 
        if($this->helper->getActivity()){
            $this->helper->setActivity();
            if(!empty($_POST["nombre"])&&!empty($_POST["descripcion"])&&!empty($_POST["precio"])&&
                !empty($_POST["stock"])&&!empty($_POST["nameCategoria"])){ 
                $nombre=$_POST["nombre"]; 
                $descripcion=$_POST["descripcion"]; 
                $precio=$_POST["precio"]; 
                $stock=$_POST["stock"]; 
                $nombreCategoria=$_POST["nameCategoria"]; 
                $id_categoria= $this->model->getIdCategoria($nombreCategoria);
                if(!$this->existeProducto($nombre,$precio,$descripcion,$id_categoria->id)){
                    $this->model->insertarProducto($nombre,$descripcion,$precio,$stock,$id_categoria->id); 
                }else{ 
                    $idProducto = $this->model->getIdProducto($nombre,$precio,$descripcion,$id_categoria->id);
                    $producto= $this->model->getItem($idProducto->id);
                    $stock = $stock + $producto->stock;
                    $this->model->setStock($idProducto->id,$stock);
                } 
                $this->view->home();          
            }else{ 
                $this->view->error(null,true,"home","",$this->helper->getSesion());
            }
        }else{ 
            $this->helper->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->helper->getSesion(),$error);
        }
    } 

    function eliminarProducto($params=null){ 
        if($this->helper->getActivity()){
            $this->helper->setActivity();
            $id_producto=$params[":ID"]; 
            $this->model->eliminarProducto($id_producto);
            $this->view->home(); 
        }else{
            $this->helper->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->helper->getSesion(),$error);
        }
    } 

    function showFormEditar($params=null){ 
        if($this->helper->getActivity()){
            $this->helper->setActivity();
            $id_producto=$params[":ID"]; 
            $categorias=$this->model->getCategorias(); 
            $producto=$this->model->getItem($id_producto);
            $this->helper->setActivity();
            $this->view->showFormEditar($id_producto,$categorias,$producto,$this->helper->getSesion());
        }else{ 
            $this->helper->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->helper->getSesion(),$error);
        }
    }

    function editarProducto(){ 
        if($this->helper->getActivity()){
            $this->helper->setActivity();
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
                if(!$this->existeProducto($nombre,$precio,$descripcion,$idCategoria->id)){
                    $this->model->editarProducto($idProducto,$nombre,$descripcion,$precio,$stock,$idCategoria->id); 
                    $this->view->home(); 
                }else{ 
                    $error="El producto ingresado ya existe"; 
                    $this->view->error($error,null,"formEditar/",$idProducto,$this->helper->getSesion());
                }                
            }else{ 
                $this->view->error(null,null,"formEditar/",$idProducto,$this->helper->getSesion());
            }
        }else{ 
            $this->helper->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->helper->getSesion(),$error); 
        }
    } 

    function showFormEditarCategoria($params=null){ 
        if($this->helper->getActivity()){
            $this->helper->setActivity();
            $nombreCategoria=$params[":NOMBRE"]; 
            $id_categoria=$this->model->getIdCategoria($nombreCategoria); 
            $this->view->showFormEditarCategoria($this->model->getCategoria($id_categoria->id),$this->helper->getSesion());
        }else{ 
            $this->helper->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->helper->getSesion(),$error);
        }
    } 

    function editarCategoria(){ 
        if($this->helper->getActivity()){
            $this->helper->setActivity();
            $id_categoria=$_POST["id_categoria"];
            $nombreAnterior= $this->model->getCategoria($id_categoria);
            if(!empty($_POST["nombreCategoria"])){ 
                $nombreCategoria=$_POST["nombreCategoria"]; 
                if(!$this->existeCategoria($nombreCategoria)){
                    $this->model->editarCategoria($id_categoria,$nombreCategoria); 
                    $this->view->redirectionCategorias();
                }else{ 
                    $error="La categoria ingresada ya existe";
                    $this->view->error($error,true,"formEditarCategoria/",$nombreCategoria,$this->helper->getSesion());
                }    

            }else{  
                $this->view->error(null,null,"formEditarCategoria/", $nombreAnterior->name,$this->helper->getSesion());
            }
        }else{ 
            $this->helper->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->helper->getSesion(),$error);
        }
    } 

    function eliminarCategoria($params=null){ 
        if($this->helper->getActivity()){
            $this->helper->setActivity();
            $nombreCategoria=$params[":NOMBRE"]; 
            $id_categoria=$this->model->getIdCategoria($nombreCategoria); 
            $this->model->eliminarCategoria($id_categoria->id); 
            $this->view->redirectionCategorias();
        }else{ 
            $this->helper->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->helper->getSesion(),$error);
        }
    }

    function existeProducto($nombre,$precio,$descripcion,$idCategoria){ 
        $producto= $this->model->getIdProducto($nombre,$precio,$descripcion,$idCategoria);
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
        }else{ 
            return true;
        }
    }

    function insertarCategoria(){ 
        if($this->helper->getActivity()){
            $this->helper->setActivity();
            if(!empty($_POST["nombreCategoria"])){
                $nombre=$_POST["nombreCategoria"];
                if(!$this->existeCategoria($nombre)){  
                    $this->model->insertarCategoria($nombre); 
                    $this->view->redirectionCategorias();
                }else{ 
                    $error="La categoria ingresada ya existe";
                    $this->view->error($error,true,null,null,$this->helper->getSesion());
                }
                
            } else { 
                $this->view->error(null,true,null,null,$this->helper->getSesion());
            }
        }else{ 
            $this->helper->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->helper->getSesion(),$error);
        }
    } 

    function exit(){ 
        $this->helper->cerrarSesion(); 
        $this->view->Home();
    }

    function iniciarSesion(){ 
        if(!empty($_POST["email"])&&!empty($_POST["password"])){
            $object= $this->model->getPassword($_POST["email"]);
            if($object!=false && password_verify($_POST["password"],$object->password)){ 
                session_start();
                $this->helper->setSesion("admin");
                $this->helper->setActivity();
                $this->view->home();
            }else{ 
            $error= "Usuario o contraseña incorrecto";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->helper->getSesion(),$error);
            }
        }else{ 
            $error= "Por favor complete todos los campos";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->helper->getSesion(),$error);
        }
    }


    // VER SI SE PUEDE ARREGLAR CON VIEW->HOME CUANDO CADUCA LA SESION
}
