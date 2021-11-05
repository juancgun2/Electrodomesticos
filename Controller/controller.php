<?php 
require_once "./View/view.php"; 
require_once "./Model/modelProducto.php";
require_once "./Model/modelCategorias.php";
require_once "./Model/modelImagen.php";
require_once "./Helper/helper.php";

Class controller{ 
    private $modelProducto; 
    private $modelCategorias;
    private $modelImagen;
    private $view;
    private $helper;
    private $cantidadProductos;

    function __construct(){ 
        $this->modelProducto = new modelProducto(); 
        $this->modelCategorias = new modelCategorias();
        $this->cantidadProductos = $this->modelProducto->getCantidad()->cantidad;
        $this->modelImagen = new modelImagen();
        $this->view= new view(); 
        $this->helper= new helper();
    } 

    private function getUniqImage($productos){ 
        $imagenes = [];
        foreach ($productos as $p) {
            $objPath=$this->modelImagen->getPathImagen($p->id);
            if ($objPath)
                $imagenes[]=$objPath->path;
            else 
                $imagenes[]="./img/default.png";
        }
        return $imagenes;
    }

    private function getLimitProduct() { 
        if(isset($_GET["cantidad"])) {
            $limit = $_GET["cantidad"];
        } else {
            $limit = 4;
        }
        return $limit;
    }

    private function getPage() { 
        if(isset($_GET["page"])) {
            $pagina = $_GET["page"];
        } else { 
            $pagina = 1;
        }
        return $pagina;
    }

    function getPaginados() { 
        $nextPage = true;
        $limit = $this->getLimitProduct();
        $pagina = $this->getPage();
        $contador = $pagina - 1;
        $contador = $contador * $limit;
        if(($contador + $limit) > $this->cantidadProductos) 
            $nextPage = false;
        $productos = $this->modelProducto->getProductosPaginados($contador, $limit); 
        $imagenes = $this->getUniqImage($productos);
        if($this->helper->getRol()) {
            if($this->helper->getActivity()) {
                $this->view->showAllItems($productos, $this->modelCategorias->getCategorias(), $this->helper->getRol(), $imagenes, $this->helper->getEmail(), $pagina, $nextPage);
            }else 
                $this->helper->caducoSesion();
        } else{ 
            $this->view->showAllItems($productos, $this->modelCategorias->getCategorias(), false, $imagenes, null, $pagina, $nextPage);  
        }
    }
    
    function filtroAvanzado(){ 
        if( isset($_POST["filtro_precioMinimo"]) && isset($_POST["filtro_precioMaximo"])) { 
            $nextPage = true;
            $limit = $this->getLimitProduct();
            $page = $this->getPage();
            $contador = $page - 1; 
            $contador = $contador * $limit;  
            $productos = $this->modelProducto->getFiltrados($_POST["filtro_precioMinimo"], $_POST["filtro_precioMaximo"], $contador, $limit);
            if( count($productos) < $limit)    
                $nextPage = false; 
            $imagenes = $this->getUniqImage($productos);
            if($this->helper->getRol()) {
                if($this->helper->getActivity())
                    $this->view->showAllItems($productos, $this->modelCategorias->getCategorias(), $this->helper->getRol(), $imagenes, $this->helper->getEmail(), $page, $nextPage);
                else 
                    $this->helper->caducoSesion();
            }else 
                $this->view->showAllItems($productos, $this->modelCategorias->getCategorias(), false, $imagenes, null, $page, $nextPage);
                
        }else{ 
            $this->view->home();
        }
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
        $nextPage = true;
        $nombreCategoria = $params[":NOMBRE"];
        $page = $this->getPage();
        $limit = $this->getLimitProduct();
        $contador = $page - 1;
        $contador = $contador * $limit;
        $id_categoria = $this->modelCategorias->getIdCategoria($nombreCategoria);
        $productosOrdenados = $this->modelProducto->getItemsInCategorias($id_categoria->id, $contador, $limit); 
        if(($contador + $limit) > count($productosOrdenados)) 
            $nextPage = false;
        $imagenes = $this->getUniqImage($productosOrdenados);
        if($this->helper->getRol()){
            if($this->helper->getActivity())
                $this->view->showAllItems($productosOrdenados, $this->modelCategorias->getCategorias(), $this->helper->getRol(), $imagenes, $this->helper->getEmail(), $page, $nextPage);
            else 
                $this->helper->caducoSesion();
        } else {
            $this->view->showAllItems($productosOrdenados, $this->modelCategorias->getCategorias(), false, $imagenes, null, $page, $nextPage);
        }
    }

    function showLogin(){ 
        if ($this->helper->getRol()) 
            $this->view->home();
        else
            $this->view->showLogin(false);
    }
}