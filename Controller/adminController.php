<?php 
require_once "./View/view.php"; 
require_once "./Model/modelProducto.php"; 
require_once "./Model/modelCategorias.php";
require_once "./Model/modelUsers.php";
require_once "./Helper/helper.php";

Class adminController{ 
    private $modelProducto;
    private $modelCategorias; 
    private $modelUsers;
    private $view;
    private $helper;

    function __construct(){ 
        $this->modelProducto = new modelProducto(); 
        $this->modelCategorias = new modelCategorias;
        $this->modelUsers = new modelUsers(); 
        $this->view= new view();
        $this->helper = new helper();
    } 

    function insertarProducto(){ 
        if($this->helper->getSesion()){
            if($this->helper->getActivity()){
                $this->helper->setActivity();
                if(!empty($_POST["nombre"])&&!empty($_POST["descripcion"])&&!empty($_POST["precio"])&&
                    !empty($_POST["stock"])&&!empty($_POST["nameCategoria"])){ 
                    $nombre=$_POST["nombre"]; 
                    $descripcion=$_POST["descripcion"]; 
                    $precio=$_POST["precio"]; 
                    $stock=$_POST["stock"]; 
                    $nombreCategoria=$_POST["nameCategoria"]; 
                    $id_categoria= $this->modelCategorias->getIdCategoria($nombreCategoria);
                    if(!$this->existeProducto($nombre,$precio,$descripcion,$id_categoria->id)){
                        $this->modelProducto->insertarProducto($nombre,$descripcion,$precio,$stock,$id_categoria->id); 
                    }else{ 
                        $idProducto = $this->modelProducto->getIdProducto($nombre,$precio,$descripcion,$id_categoria->id);
                        $producto= $this->modelProducto->getItem($idProducto->id);
                        $stock = $stock + $producto->stock;
                        $this->modelProducto->setStock($idProducto->id,$stock);
                    } 
                    $this->view->home();          
                }else{ 
                    $this->view->error(null,true,"home","",true);
                }
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,$error);
            }
        }else{ 
            $error= "Acceso denegado. Por favor inicie sesion";
            $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,$error);
        }
    } 

    function eliminarProducto($params=null){ 
        if($this->helper->getSesion()){
            if($this->helper->getActivity()){
                $this->helper->setActivity();
                $id_producto=$params[":ID"]; 
                $this->modelProducto->eliminarProducto($id_producto);
                $this->view->home(); 
            }else{
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,$error);
            }
        }else{ 
            $error= "Acceso denegado. Por favor inicie sesion";
            $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,$error);
        }
    } 

    function showFormEditar($params=null){ 
        if($this->helper->getSesion()){
            if($this->helper->getActivity()){
                $this->helper->setActivity();
                $id_producto=$params[":ID"]; 
                $categorias=$this->modelCategorias->getCategorias(); 
                $producto=$this->modelProducto->getItem($id_producto);
                $this->helper->setActivity();
                $this->view->showFormEditar($id_producto,$categorias,$producto,true);
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,$error);
            }
        }else{ 
            $error= "Acceso denegado. Por favor inicie sesion";
            $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,$error);
        }
    }

    function editarProducto(){ 
        if($this->helper->getSesion()){
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
                    $idCategoria= $this->modelCategorias->getIdCategoria($nombreCategoria);
                    if(!$this->existeProducto($nombre,$precio,$descripcion,$idCategoria->id)){
                        $this->modelProducto->editarProducto($idProducto,$nombre,$descripcion,$precio,$stock,$idCategoria->id); 
                        $this->view->home(); 
                    }else{ 
                        $error="El producto ingresado ya existe"; 
                        $this->view->error($error,null,"formEditar/",$idProducto,true);
                    }                
                }else{ 
                    $this->view->error(null,null,"formEditar/",$idProducto,true);
                }
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,$error); 
            }
        }else{ 
            $error= "Acceso denegado. Por favor inicie sesion";
            $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,$error);
        }
    } 

    function showFormEditarCategoria($params=null){ 
        if($this->helper->getSesion()){
            if($this->helper->getActivity()){
                $this->helper->setActivity();
                $nombreCategoria=$params[":NOMBRE"]; 
                $id_categoria=$this->modelCategorias->getIdCategoria($nombreCategoria); 
                $this->view->showFormEditarCategoria($this->modelCategorias->getCategoria($id_categoria->id),true);
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,$error);
            }
        }else{ 
            $error= "Acceso denegado. Por favor inicie sesion";
            $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,$error);
        }
    } 

    function editarCategoria(){ 
        if($this->helper->getSesion()){
            if($this->helper->getActivity()){
                $this->helper->setActivity();
                $id_categoria=$_POST["id_categoria"];
                $nombreAnterior= $this->modelCategorias->getCategoria($id_categoria);
                if(!empty($_POST["nombreCategoria"])){ 
                    $nombreCategoria=$_POST["nombreCategoria"]; 
                    if(!$this->existeCategoria($nombreCategoria)){
                        $this->modelCategorias->editarCategoria($id_categoria,$nombreCategoria); 
                        $this->view->redirectionCategorias();
                    }else{ 
                        $error="La categoria ingresada ya existe";
                        $this->view->error($error,true,"formEditarCategoria/",$nombreCategoria,true);
                    }    

                }else{  
                    $this->view->error(null,null,"formEditarCategoria/", $nombreAnterior->name,true);
                }
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,$error);
            }
        }else{ 
            $error= "Acceso denegado. Por favor inicie sesion";
            $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,$error);
        }
    } 

    function eliminarCategoria($params=null){ 
        if($this->helper->getSesion()){
            if($this->helper->getActivity()){
                $this->helper->setActivity();
                $nombreCategoria=$params[":NOMBRE"]; 
                $id_categoria=$this->modelCategorias->getIdCategoria($nombreCategoria); 
                $this->modelCategorias->eliminarCategoria($id_categoria->id); 
                $this->view->redirectionCategorias();
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,$error);
            }
        }else{ 
            $error= "Acceso denegado. Por favor inicie sesion";
            $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,$error);
        }
    }

    function existeProducto($nombre,$precio,$descripcion,$idCategoria){ 
        $producto= $this->modelProducto->getIdProducto($nombre,$precio,$descripcion,$idCategoria);
        if($producto===false){ 
            return false;
        }else{
            return true;
        }
    }

    function existeCategoria($nombre){ 
        $idCategoria=$this->modelCategorias->getIdCategoria($nombre); 
        if($idCategoria===false){ 
            return false;
        }else{ 
            return true;
        }
    }

    function insertarCategoria(){ 
        if($this->helper->getSesion()){
            if($this->helper->getActivity()){
                $this->helper->setActivity();
                if(!empty($_POST["nombreCategoria"])){
                    $nombre=$_POST["nombreCategoria"];
                    if(!$this->existeCategoria($nombre)){  
                        $this->modelCategorias->insertarCategoria($nombre); 
                        $this->view->redirectionCategorias();
                    }else{ 
                        $error="La categoria ingresada ya existe";
                        $this->view->error($error,true,null,null,true);
                    }
                    
                } else { 
                    $this->view->error(null,true,null,null,true);
                }
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,$error);
            }
        }else{ 
            $error= "Acceso denegado. Por favor inicie sesion";
            $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,$error);
        }
    } 

    function exit(){ 
        $this->helper->cerrarSesion(); 
        $this->view->Home();
    }

    function iniciarSesion(){ 
        if(!empty($_POST["email"])&&!empty($_POST["password"])){
            $objectPass= $this->modelUsers->getPassword($_POST["email"]);
            if($objectPass!=false && password_verify($_POST["password"],$objectPass->password)){ 
                session_start();
                $this->helper->setSesion("admin");
                $this->helper->setActivity();
                $this->view->home();
            }else{ 
            $error= "Usuario o contraseña incorrecto";
            $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,$error);
            }
        }else{ 
            $error= "Por favor complete todos los campos";
            $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,$error);
        }
    }

    function showUsuarios(){
        $this->view->renderUsuarios($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),"admin",$this->modelUsers->getUsuarios());
    }
}
