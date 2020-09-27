<?php 
require_once 'libs/smarty/Smarty.class.php';
// <base href="'.BASE_URL.'"> todos los href tienen base_url como base de la url 
Class view{ 
    private $smarty;
    private $titulo;
    private $h1;

    function __construct(){ 
        $this->titulo= "J&J Electrodomesticos";
    }

    function showAllItems($productos,$categorias=null){ 
        $smarty = new Smarty();
        $smarty->assign('titulo' , $this->titulo); 
        $smarty->assign('BASE_URL' , BASE_URL); 
        $smarty->assign('position' , "home");
        $smarty->assign('productos' , $productos);
        $smarty->assign('categorias' , $categorias);  
        $smarty->display('./templates/formInsert.tpl');
    } 

    function showProductosPorCategoria($productos){ 
        $smarty = new Smarty();
        $smarty->assign('titulo' , $this->titulo); 
        $smarty->assign('BASE_URL' , BASE_URL); 
        $smarty->assign('position' , "notHome");
        $smarty->assign('productos' , $productos); 
        $smarty->display('./templates/allItems.tpl');
    }

    function showDetalleItem($detalle){ 
        $smarty = new Smarty();
        $smarty->assign('titulo' , $this->titulo); 
        $smarty->assign('BASE_URL' , BASE_URL);
        $smarty->assign('position' , "notHome");
        $smarty->assign('detalle' , $detalle); 
        $smarty->display('./templates/detalleItem.tpl');
    } 

    function showCategorias($categorias){  
        $smarty = new Smarty();
        $smarty->assign('titulo' , $this->titulo); 
        $smarty->assign('BASE_URL' , BASE_URL); 
        $smarty->assign('position' , "notHome");
        $smarty->assign('categorias' , $categorias); 
        $smarty->display('./templates/categorias.tpl');
    } 

    function alertDeleteCategoria($nombreCategoria){ 
       //aca va un alert y despues se elimina la categoria
    }

    function redirectionCategorias(){ 
        header("Location: ".BASE_URL."Categorias");
    }

    function home(){ 
        header("Location: ".BASE_URL."");
    } 

    function showFormEditar($id_producto,$categorias,$producto){ 
        $smarty = new Smarty();
        $smarty->assign('titulo' , $this->titulo); 
        $smarty->assign('BASE_URL' , BASE_URL); 
        $smarty->assign('position' , "notHome");
        $smarty->assign('categorias' , $categorias);
        $smarty->assign('producto' , $producto);
        $smarty->assign('id_producto' , $id_producto); 
        $smarty->display('./templates/formEditProducto.tpl');
    } 

    function showFormEditarCategoria($categoria){ 
        $smarty = new Smarty();
        $smarty->assign('titulo' , $this->titulo); 
        $smarty->assign('BASE_URL' , BASE_URL);
        $smarty->assign('position' , "notHome");
        $smarty->assign('categoria' , $categoria);
        $smarty->display('./templates/formEditcategoria.tpl');
    }

    function error($error=null,$insertCategoria=null,$update=null,$id=null){ 
        if($error==null){ 
            $error="Por favor complete todos los campos";
        }
        if($insertCategoria!=null && $update==null){
            $smarty = new Smarty();
            $smarty->assign('titulo' , $this->titulo); 
            $smarty->assign('BASE_URL' , BASE_URL);
            $smarty->assign('position' , "error"); 
            $smarty->assign('error' , $error);
            $smarty->assign('categoria' , "");
            $smarty->assign('update' , "Categorias");
            $smarty->assign('id' , "");
            $smarty->display('./templates/header.tpl');
        }elseif ($update!=null){ 
            $smarty = new Smarty();
            $smarty->assign('titulo' , $this->titulo); 
            $smarty->assign('BASE_URL' , BASE_URL);
            $smarty->assign('position' , "error"); 
            $smarty->assign('error' , $error);
            $smarty->assign('categoria' , "");
            $smarty->assign('update' , $update);
            $smarty->assign('id' , $id);
            $smarty->display('./templates/header.tpl');
        }
    }

}