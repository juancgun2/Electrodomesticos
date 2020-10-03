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
        if($this->getSesion()){
            if($this->getActivity()){
                $this->setActivity();
                $this->view->showAllItems($this->model->getAllItems(),$this->model->getCategorias(),$this->getSesion());
                die();
            }else 
            $this->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->getSesion(),$error);
        }else{ 
            $this->view->showAllItems($this->model->getAllItems(),$this->model->getCategorias(),$this->getSesion());
        } 
    }

    function showDetalleItem($params=null){ 
        $id_producto=$params[':ID'];   
        $this->view->showDetalleItem($this->model->getItem($id_producto),$this->getSesion());
    } 

    function showCategorias(){ 
        if($this->getSesion()){
            if($this->getActivity()){
                $this->setActivity();
                $this->view->showCategorias($this->model->getCategorias(),$this->getSesion());
            }else{ 
                $this->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->getSesion(),$error);
            }
        }else{ 
            $this->view->showCategorias($this->model->getCategorias(),$this->getSesion()); 
        }
    }

    function filtrarPorCategorias($params=null){ 
        $nombreCategoria=$params[":NOMBRE"];
        $id_categoria= $this->model->getIdCategoria($nombreCategoria);
        if($this->getSesion()){
            if($this->getActivity()){
                $this->setActivity();
                $this->view->showAllItems($this->model->getItemsInOrder($id_categoria->id),$this->model->getCategorias(),$this->getSesion());
            }else{ 
                $this->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->getSesion(),$error);
            }
        }else{ 
            $this->view->showAllItems($this->model->getItemsInOrder($id_categoria->id),$this->model->getCategorias(),$this->getSesion());
        }
    }

    function insertarProducto(){ 
        if($this->getActivity()){
            $this->setActivity();
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
                $this->view->error(null,true,"home","",$this->getSesion());
            }
        }else{ 
            $this->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->getSesion(),$error);
        }
    } 

    function eliminarProducto($params=null){ 
        if($this->getActivity()){
            $this->setActivity();
            $id_producto=$params[":ID"]; 
            $this->model->eliminarProducto($id_producto);
            $this->view->home(); 
        }else{
            $this->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->getSesion(),$error);
        }
    }

    function showFormEditar($params=null){ 
        if($this->getActivity()){
            $this->setActivity();
            $id_producto=$params[":ID"]; 
            $categorias=$this->model->getCategorias(); 
            $producto=$this->model->getItem($id_producto);
            $this->setActivity();
            $this->view->showFormEditar($id_producto,$categorias,$producto,$this->getSesion());
        }else{ 
            $this->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->getSesion(),$error);
        }
    }

    function editarProducto(){ 
        if($this->getActivity()){
            $this->setActivity();
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
                    $this->view->error($error,null,"formEditar/",$idProducto,$this->getSesion());
                }                
            }else{ 
                $this->view->error(null,null,"formEditar/",$idProducto,$this->getSesion());
            }
        }else{ 
            $this->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->getSesion(),$error); 
        }
    } 
    // revisar showFormEditarCategoria si se puede agregar a getIdCategoria que traiga el nombre tambien.
    // El problema seria que no retorne false cuando llame a existeCategoria.
    function showFormEditarCategoria($params=null){ 
        if($this->getActivity()){
            $this->setActivity();
            $nombreCategoria=$params[":NOMBRE"]; 
            $id_categoria=$this->model->getIdCategoria($nombreCategoria); 
            $this->view->showFormEditarCategoria($this->model->getCategoria($id_categoria->id),$this->getSesion());
        }else{ 
            $this->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->getSesion(),$error);
        }
    } 

    function editarCategoria(){ 
        if($this->getActivity()){
            $this->setActivity();
            $id_categoria=$_POST["id_categoria"];
            $nombreAnterior= $this->model->getCategoria($id_categoria);
            if(!empty($_POST["nombreCategoria"])){ 
                $nombreCategoria=$_POST["nombreCategoria"]; 
                if(!$this->existeCategoria($nombreCategoria)){
                    $this->model->editarCategoria($id_categoria,$nombreCategoria); 
                    $this->view->redirectionCategorias();
                }else{ 
                    $error="La categoria ingresada ya existe";
                    $this->view->error($error,true,"formEditarCategoria/",$nombreCategoria,$this->getSesion());
                }    

            }else{  
                $this->view->error(null,null,"formEditarCategoria/", $nombreAnterior->name,$this->getSesion());
            }
        }else{ 
            $this->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->getSesion(),$error);
        }
    } 

    function eliminarCategoria($params=null){ 
        if($this->getActivity()){
            $this->setActivity();
            $nombreCategoria=$params[":NOMBRE"]; 
            $id_categoria=$this->model->getIdCategoria($nombreCategoria); 
            $this->model->eliminarCategoria($id_categoria->id); 
            $this->view->redirectionCategorias();
        }else{ 
            $this->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->getSesion(),$error);
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
        if($this->getActivity()){
            $this->setActivity();
            if(!empty($_POST["nombreCategoria"])){
                $nombre=$_POST["nombreCategoria"];
                if(!$this->existeCategoria($nombre)){  
                    $this->model->insertarCategoria($nombre); 
                    $this->view->redirectionCategorias();
                }else{ 
                    $error="La categoria ingresada ya existe";
                    $this->view->error($error,true,null,null,$this->getSesion());
                }
                
            } else { 
                $this->view->error(null,true,null,null,$this->getSesion());
            }
        }else{ 
            $this->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->getSesion(),$error);
        }
    } 

    function showLogin(){ 
        $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->getSesion());
    }

    function iniciarSesion(){ 
        if(!empty($_POST["email"])&&!empty($_POST["password"])){
            $object= $this->model->getPassword($_POST["email"]);
            if($object!=false && password_verify($_POST["password"],$object->password)){ 
                session_start();
                $_SESSION["nombre"]="admin";
                $_SESSION["lastActivity"]= time();
                $this->view->home();
            }else{ 
            $error= "Usuario o contraseña incorrecto";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->getSesion(),$error);
            }
        }else{ 
            $error= "Por favor complete todos los campos";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->getSesion(),$error);
        }
    }

    function getActivity(){
        if(!isset($_SESSION))
            session_start();  
        if(time()-$_SESSION["lastActivity"] > 10) {
            return false;
        }else{
            return true;
        }
    }

    function setActivity(){ 
        if(!isset($_SESSION))
        session_start(); 
        $_SESSION["lastActivity"]= time();
    }

    function getSesion(){ 
        if(!isset($_SESSION))
        session_start();
        if(empty($_SESSION["nombre"])){ 
            return false;
        }else{ 
            return true;
        }
    } 

    function cerrarSesion(){
        if(!isset($_SESSION))
        session_start(); 
        $_SESSION["nombre"]='';
        $_SESSION["lastActivity"]="";
    }
}