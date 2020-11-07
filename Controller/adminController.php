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
        if($this->helper->getRol()){
            if($this->helper->getActivity()){
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
                    $this->view->error(null,true,"home","","admin",$this->helper->getEmail());
                }
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin(false,null,$error);
            }
        }else{ 
            $error= "Acceso denegado. Por favor inicie sesion";
            $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false,null,$error);
        }
    } 

    function eliminarProducto($params=null){ 
        if($this->helper->getRol()){
            if($this->helper->getActivity()){
                $id_producto=$params[":ID"]; 
                $this->modelProducto->eliminarProducto($id_producto);
                $this->view->home(); 
            }else{
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin(false,null,$error);
            }
        }else{ 
            $error= "Acceso denegado. Por favor inicie sesion";
            $this->view->showLogin(false,null,$error);
        }
    } 

    function showFormEditar($params=null){ 
        if($this->helper->getRol()){
            if($this->helper->getActivity()){
                $id_producto=$params[":ID"]; 
                $categorias=$this->modelCategorias->getCategorias(); 
                $producto=$this->modelProducto->getItem($id_producto);
                $this->view->showFormEditar($id_producto,$categorias,$producto,"admin",$this->helper->getEmail());
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin(false,null,$error);
            }
        }else{ 
            $error= "Acceso denegado. Por favor inicie sesion";
            $this->view->showLogin(false,null,$error);
        }
    }

    function editarProducto(){ 
        if($this->helper->getRol()){
            if($this->helper->getActivity()){
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
                        $this->view->error($error,null,"formEditar/",$idProducto,"admin",$this->helper->getEmail());
                    }                
                }else{ 
                    $this->view->error(null,null,"formEditar/",$idProducto,"admin",$this->helper->getEmail());
                }
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin(false,null,$error); 
            }
        }else{ 
            $error= "Acceso denegado. Por favor inicie sesion";
            $this->view->showLogin(false,null,$error);
        }
    } 

    function showFormEditarCategoria($params=null){ 
        if($this->helper->getRol()){
            if($this->helper->getActivity()){
                $nombreCategoria=$params[":NOMBRE"]; 
                $id_categoria=$this->modelCategorias->getIdCategoria($nombreCategoria); 
                $this->view->showFormEditarCategoria($this->modelCategorias->getCategoria($id_categoria->id),"admin",$this->helper->getEmail());
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin(false,null,$error);
            }
        }else{ 
            $error= "Acceso denegado. Por favor inicie sesion";
            $this->view->showLogin(false,null,$error);
        }
    } 

    function editarCategoria(){ 
        if($this->helper->getRol()){
            if($this->helper->getActivity()){
                $id_categoria=$_POST["id_categoria"];
                $nombreAnterior= $this->modelCategorias->getCategoria($id_categoria);
                if(!empty($_POST["nombreCategoria"])){ 
                    $nombreCategoria=$_POST["nombreCategoria"]; 
                    if(!$this->existeCategoria($nombreCategoria)){
                        $this->modelCategorias->editarCategoria($id_categoria,$nombreCategoria); 
                        $this->view->redirectionCategorias();
                    }else{ 
                        $error="La categoria ingresada ya existe";
                        $this->view->error($error,true,"formEditarCategoria/",$nombreCategoria,"admin",$this->helper->getEmail());
                    }    

                }else{  
                    $this->view->error(null,null,"formEditarCategoria/", $nombreAnterior->name,"admin",$this->helper->getEmail());
                }
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin(false,null,$error);
            }
        }else{ 
            $error= "Acceso denegado. Por favor inicie sesion";
            $this->view->showLogin(false,null,$error);
        }
    } 

    function eliminarCategoria($params=null){ 
        if($this->helper->getRol()){
            if($this->helper->getActivity()){
                $nombreCategoria=$params[":NOMBRE"]; 
                $id_categoria=$this->modelCategorias->getIdCategoria($nombreCategoria); 
                $this->modelCategorias->eliminarCategoria($id_categoria->id); 
                $this->view->redirectionCategorias();
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin(false,null,$error);
            }
        }else{ 
            $error= "Acceso denegado. Por favor inicie sesion";
            $this->view->showLogin(false,null,$error);
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
        if($this->helper->getRol()){
            if($this->helper->getActivity()){
                if(!empty($_POST["nombreCategoria"])){
                    $nombre=$_POST["nombreCategoria"];
                    if(!$this->existeCategoria($nombre)){  
                        $this->modelCategorias->insertarCategoria($nombre); 
                        $this->view->redirectionCategorias();
                    }else{ 
                        $error="La categoria ingresada ya existe";
                        $this->view->error($error,true,null,null,"admin",$this->helper->getEmail());
                    }
                    
                } else { 
                    $this->view->error(null,true,null,null,"admin",$this->helper->getEmail());
                }
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin(false,null,$error);
            }
        }else{ 
            $error= "Acceso denegado. Por favor inicie sesion";
            $this->view->showLogin(false,null,$error);
        }
    } 

    function showUsuarios(){
        $this->view->renderUsuarios("admin",$this->modelUsers->getUsuarios(),$this->helper->getEmail());
    }
}
