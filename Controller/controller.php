<?php 
require_once "./View/view.php"; 
require_once "./Model/modelProducto.php";
require_once "./Model/modelCategorias.php";
require_once "./Model/modelComentario.php";

Class controller{ 
    private $modelProducto; 
    private $modelCategorias;
    private $modelComentario;
    private $modelImagen;
    private $view;
    private $helper;

    function __construct(){ 
        $this->modelProducto = new modelProducto(); 
        $this->modelCategorias = new modelCategorias();
        $this->modelComentario = new modelComentario();
        $this->modelImagen = new modelImagen();
        $this->view= new view(); 
        $this->helper= new helper();
    } 

    function Home(){ 
        if($this->helper->getRol()){
            if($this->helper->getActivity())
                $this->view->showAllItems($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),$this->helper->getRol(),$this->helper->getEmail());
            else 
                $this->helper->caducoSesion();
        } else
            $this->view->showAllItems($this->modelProducto->getAllItems(),$this->modelCategorias->getCategorias(),false);    
    }

    function showDetalleItem($params=null){ 
        $id_producto = $params[':ID']; 
        if($this->helper->getRol()) {
            if($this->helper->getActivity()) 
                $this->view->showDetalleItem($this->modelProducto->getItem($id_producto),$this->helper->getRol(),
                                                $this->helper->getEmail(),$this->helper->getIdUsuario(),
                                                $this->modelImagen->getImagenes($id_producto));
            else
                $this->helper->caducoSesion();
        } else
            $this->view->showDetalleItem($this->modelProducto->getItem($id_producto), false ,null, null, $this->modelImagen->getImagenes($id_producto));
    } 

    function showCategorias(){ 
        if($this->helper->getRol()){
            if($this->helper->getActivity()) 
                $this->view->showCategorias($this->modelCategorias->getCategorias(),$this->helper->getRol(),$this->helper->getEmail());
            else 
                $this->helper->caducoSesion();
        } else 
            $this->view->showCategorias($this->modelCategorias->getCategorias(),false); 
    }

    function filtrarPorCategorias($params=null){ 
        $nombreCategoria = $params[":NOMBRE"];
        $id_categoria = $this->modelCategorias->getIdCategoria($nombreCategoria);
        if(!$this->helper->getRol()){
            if($this->helper->getActivity())
                $this->view->showAllItems($this->modelProducto->getItemsInOrder($id_categoria->id),$this->modelCategorias->getCategorias(),$this->helper->getRol(),$this->helper->getEmail());
            else 
                $this->helper->caducoSesion();
        } else 
            $this->view->showAllItems($this->modelProducto->getItemsInOrder($id_categoria->id),$this->modelCategorias->getCategorias(),"");
    }

    // revisar showFormEditarCategoria si se puede agregar a getIdCategoria que traiga el nombre tambien.
    // El problema seria que no retorne false cuando llame a existeCategoria.

    function showLogin(){ 
        if ($this->helper->getRol()) 
            $this->view->home();
        else
            $this->view->showLogin(false);
    }
}