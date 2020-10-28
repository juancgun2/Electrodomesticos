<?php 
require_once "./View/view.php"; 
require_once "./Model/modelProducto.php";
require_once "./Model/modelCategorias.php";

Class controller{ 
    private $modelProducto; 
    private $modelCategorias;
    private $modelUsers;
    private $view;
    private $helper;

    function __construct(){ 
        $this->modelProducto = new modelProducto(); 
        $this->modelCategorias = new modelCategorias();
        $this->modelUsers = new modelUsers();
        $this->view= new view(); 
        $this->helper= new helper();
    } 

    function Home(){ 
        if($this->helper->getSesion()){
            if($this->helper->getActivity()){
                $this->helper->setActivity();
                $this->view->showAllItems($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),$this->helper->getSesion());
                die();
            }else 
            $this->helper->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),$this->helper->getSesion(),$error);
        }else{ 
            $this->view->showAllItems($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),$this->helper->getSesion());
        } 
    }

    function showDetalleItem($params=null){ 
        $id_producto=$params[':ID']; 
        if($this->helper->getSesion()){
            if($this->helper->getActivity()){
                $this->helper->setActivity();  
                $this->view->showDetalleItem($this->modelProducto->getItem($id_producto),$this->helper->getSesion());
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),$this->helper->getSesion(),$error);
            }
        }else{ 
            $this->view->showDetalleItem($this->modelProducto->getItem($id_producto),$this->helper->getSesion());
        }
    } 

    function showCategorias(){ 
        if($this->helper->getSesion()){
            if($this->helper->getActivity()){
                $this->helper->setActivity();
                $this->view->showCategorias($this->modelCategorias->getCategorias(),$this->helper->getSesion());
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),$this->helper->getSesion(),$error);
            }
        }else{ 
            $this->view->showCategorias($this->modelCategorias->getCategorias(),$this->helper->getSesion()); 
        }
    }

    function filtrarPorCategorias($params=null){ 
        $nombreCategoria=$params[":NOMBRE"];
        $id_categoria= $this->modelCategorias->getIdCategoria($nombreCategoria);
        if($this->helper->getSesion()){
            if($this->helper->getActivity()){
                $this->helper->setActivity();
                $this->view->showAllItems($this->modelProducto->getItemsInOrder($id_categoria->id),$this->modelCategorias->getCategorias(),$this->helper->getSesion());
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),$this->helper->getSesion(),$error);
            }
        }else{ 
            $this->view->showAllItems($this->modelProducto->getItemsInOrder($id_categoria->id),$this->modelCategorias->getCategorias(),$this->helper->getSesion());
        }
    }

    // revisar showFormEditarCategoria si se puede agregar a getIdCategoria que traiga el nombre tambien.
    // El problema seria que no retorne false cuando llame a existeCategoria.

    function showLogin(){ 
        $this->view->showLogin($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),$this->helper->getSesion());
    }

    function crearCuenta(){
        $email = $POST["newEmail"]; 
        if(!$this->modelUsers->existeCuenta){
            $password=$POST["newPassword"]; 
            $password= password_hash($password); 
            $this->modelUsers->crearCuenta($email,$password);
        }
    }
}