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

    function categoriasInOrder($params=null){ 
        $id_categoria=$params[":ID"]; 
        $this->view->showAllItems($this->model->getItemsInOrder($id_categoria),$this->model->getCategorias());
    }

}