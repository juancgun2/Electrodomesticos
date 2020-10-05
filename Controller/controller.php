<?php 
require_once "./View/view.php"; 
require_once "./Model/model.php";

Class controller{ 
    private $model; 
    private $view;
    private $helper;

    function __construct(){ 
        $this->model = new model(); 
        $this->view= new view(); 
        $this->helper= new helper();
    } 

    function Home(){ 
        if($this->helper->getSesion()){
            if($this->helper->getActivity()){
                $this->helper->setActivity();
                $this->view->showAllItems($this->model->getAllItems(),$this->model->getCategorias(),$this->helper->getSesion());
                die();
            }else 
            $this->helper->cerrarSesion();
            $error= "La sesion caduco. Por favor inicie sesion nuevamente";
            $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->helper->getSesion(),$error);
        }else{ 
            $this->view->showAllItems($this->model->getAllItems(),$this->model->getCategorias(),$this->helper->getSesion());
        } 
    }

    function showDetalleItem($params=null){ 
        $id_producto=$params[':ID']; 
        if($this->helper->getSesion()){
            if($this->helper->getActivity()){
                $this->helper->setActivity();  
                $this->view->showDetalleItem($this->model->getItem($id_producto),$this->helper->getSesion());
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->helper->getSesion(),$error);
            }
        }else{ 
            $this->view->showDetalleItem($this->model->getItem($id_producto),$this->helper->getSesion());
        }
    } 

    function showCategorias(){ 
        if($this->helper->getSesion()){
            if($this->helper->getActivity()){
                $this->helper->setActivity();
                $this->view->showCategorias($this->model->getCategorias(),$this->helper->getSesion());
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->helper->getSesion(),$error);
            }
        }else{ 
            $this->view->showCategorias($this->model->getCategorias(),$this->helper->getSesion()); 
        }
    }

    function filtrarPorCategorias($params=null){ 
        $nombreCategoria=$params[":NOMBRE"];
        $id_categoria= $this->model->getIdCategoria($nombreCategoria);
        if($this->helper->getSesion()){
            if($this->helper->getActivity()){
                $this->helper->setActivity();
                $this->view->showAllItems($this->model->getItemsInOrder($id_categoria->id),$this->model->getCategorias(),$this->helper->getSesion());
            }else{ 
                $this->helper->cerrarSesion();
                $error= "La sesion caduco. Por favor inicie sesion nuevamente";
                $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->helper->getSesion(),$error);
            }
        }else{ 
            $this->view->showAllItems($this->model->getItemsInOrder($id_categoria->id),$this->model->getCategorias(),$this->helper->getSesion());
        }
    }

    // revisar showFormEditarCategoria si se puede agregar a getIdCategoria que traiga el nombre tambien.
    // El problema seria que no retorne false cuando llame a existeCategoria.

    function showLogin(){ 
        $this->view->showLogin($this->model->getAllItems(),$this->model->getCategorias(),$this->helper->getSesion());
    }
}