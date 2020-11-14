<?php 
require_once "./View/view.php"; 
require_once "./Model/modelProducto.php";
require_once "./Model/modelCategorias.php";

Class controller{ 
    private $modelProducto; 
    private $modelCategorias;
    private $view;
    private $helper;

    function __construct(){ 
        $this->modelProducto = new modelProducto(); 
        $this->modelCategorias = new modelCategorias();
        $this->view= new view(); 
        $this->helper= new helper();
    } 

    function Home(){ 
        if($this->helper->getRol()){
            if($this->helper->getActivity()){
                $this->view->showAllItems($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),$this->helper->getRol(),$this->helper->getEmail());
                die();
                }
            else {
            $this->helper->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin(false,null,$error);
            }
        }
        else
            $this->view->showAllItems($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),$this->helper->getRol());    
    }

    function showDetalleItem($params=null){ 
        $id_producto=$params[':ID']; 
        if($this->helper->getRol()){
            if($this->helper->getActivity()){ 
                $this->view->showDetalleItem($this->modelProducto->getItem($id_producto),$this->helper->getRol(),$this->helper->getEmail(),$this->helper->getIdUsuario());
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin(false,null,$error);
            }
        }else{ 
            $this->view->showDetalleItem($this->modelProducto->getItem($id_producto),$this->helper->getRol());
        }
    } 

    function showCategorias(){ 
        if($this->helper->getRol()){
            if($this->helper->getActivity()){
                $this->view->showCategorias($this->modelCategorias->getCategorias(),$this->helper->getRol(),$this->helper->getEmail());
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin(false,null,$error);
            }
        }else{ 
            $this->view->showCategorias($this->modelCategorias->getCategorias(),$this->helper->getRol()); 
        }
    }

    function filtrarPorCategorias($params=null){ 
        $nombreCategoria=$params[":NOMBRE"];
        $id_categoria= $this->modelCategorias->getIdCategoria($nombreCategoria);
        if($this->helper->getRol()){
            if($this->helper->getActivity()){
                $this->view->showAllItems($this->modelProducto->getItemsInOrder($id_categoria->id),$this->modelCategorias->getCategorias(),$this->helper->getRol(),$this->helper->getEmail());
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin(false,null,$error);
            }
        }else{ 
            $this->view->showAllItems($this->modelProducto->getItemsInOrder($id_categoria->id),$this->modelCategorias->getCategorias(),$this->helper->getRol());
        }
    }

    // revisar showFormEditarCategoria si se puede agregar a getIdCategoria que traiga el nombre tambien.
    // El problema seria que no retorne false cuando llame a existeCategoria.

    function showLogin(){ 
        $this->view->showLogin(false);
    }
}