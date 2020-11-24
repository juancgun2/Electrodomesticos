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

    function Home(){ // REVISAR LA PAGINACION, SI FUNCIONA BIEN, ESTA FUNCION ESTA DE MAS !!!!!!!!!!!
        $productos = $this->modelProducto->getAllItems(); 
        $imagenes = $this->getUniqImage($productos);
        if($this->helper->getRol()) {
            if($this->helper->getActivity()) {
                $this->view->showAllItems($productos, $this->modelCategorias->getCategorias(), $this->helper->getRol(), $imagenes, $this->helper->getEmail());
            } else 
                $this->helper->caducoSesion();
        } else
            $this->view->showAllItems($productos, $this->modelCategorias->getCategorias(), false, $imagenes);    
    }

    function getPaginados() { // necesito pasar parametro de cantidad de productos y limite de prod por pagina
        if(isset($_GET["cantidad"])){
            $limit = $_GET["cantidad"];
        }else{  
            $limit = 4;
        }
        if(isset($_GET["page"])) {
            $contador = $_GET["page"] - 1;
            $pagina = $_GET["page"];
        } else { 
            $contador = 0;
            $pagina = 1;
        }
        if( $pagina > 1 && $limit > 4){
            print_r($pagina);
            print_r("----"); 
            print_r($limit);
            $contador = $contador * $limit - $limit;
        } else { 
            $contador = $contador * $limit;
        }
        $productos = $this->modelProducto->getProductosPaginados($contador, $limit); 
        $imagenes = $this->getUniqImage($productos);
        if($this->helper->getRol()) {
            if($this->helper->getActivity())
                $this->view->showAllItems($productos, $this->modelCategorias->getCategorias(), $this->helper->getRol(), $imagenes, $this->helper->getEmail(), $pagina);
            else 
                $this->helper->caducoSesion();
        } else 
            $this->view->showAllItems($productos, $this->modelCategorias->getCategorias(), false, $imagenes, null, $pagina);  
    }
    
    /*
    function filtroAvanzado(){ 
        if(isset($_POST["filtro_producto"])) && isset($_POST["filtro_categoria"]) && isset($_POST["filtro_precioMinimo"])
            && isset($_POST["filtro_precioMaximo"]) { 
            if(!empty($_POST["filtro_producto"]) && !empty($_POST["filtro_categoria"]) && !empty($_POST["filtro_precioMinimo"]) 
                && !empty($_POST["filtro_precioMaximo"])) { 
                    $produto = $this->modelProducto->getFiltrados($_POST["filtro_producto"], $_POST["filtro_categoria"], $_POST["filtro_precioMinimo"], $_POST["filtro_precioMaximo"]);
                    $imagenes = $this->getUniqImage($productos);
                    $this->view->showAllItems($productos, $this->modelCategorias->getCategorias(), $this->helper->getRol(), $imagenes, $this->helper->getEmail(), $pagina);
            } elseif (!empty($_POST["filtro_producto"]) && !empty($_POST["filtro_categoria"]) && !empty($_POST["filtro_precioMinimo"]) 
            && !empty($_POST["filtro_precioMaximo"]))) {
                
            }
    }*/

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
        $productosOrdenados = $this->modelProducto->getItemsInOrder($id_categoria->id); 
        $imagenes = $this->getUniqImage($productosOrdenados);
        if($this->helper->getRol()){
            if($this->helper->getActivity())
                $this->view->showAllItems($productosOrdenados, $this->modelCategorias->getCategorias(), $this->helper->getRol(), $imagenes, $this->helper->getEmail());
            else 
                $this->helper->caducoSesion();
        } else 
            $this->view->showAllItems($productosOrdenados, $this->modelCategorias->getCategorias(), false, $imagenes);
    }

    function showLogin(){ 
        if ($this->helper->getRol()) 
            $this->view->home();
        else
            $this->view->showLogin(false);
    }
}