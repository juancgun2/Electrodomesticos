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

    function showAllItems($productos,$categorias){ 
        $smarty = new Smarty();
        $smarty->assign('titulo' , $this->titulo); 
        $smarty->assign('BASE_URL' , BASE_URL); 
        $smarty->assign('position' , "home");
        $smarty->assign('categorias' , $categorias);
        $smarty->assign('productos' , $productos); 
        $smarty->display('./templates/allItems.tpl');
    } 

    function showDetalleItem($detalle){ 
        $smarty = new Smarty();
        $smarty->assign('titulo' , $this->titulo); 
        $smarty->assign('BASE_URL' , BASE_URL);
        $smarty->assign('position' , "detalleItem");
        $smarty->assign('detalle' , $detalle); 
        $smarty->display('./templates/detalleItem.tpl');
    } 

    function showCategorias($categorias){  
        $smarty = new Smarty();
        $smarty->assign('titulo' , $this->titulo); 
        $smarty->assign('BASE_URL' , BASE_URL); 
        $smarty->assign('position' , "categorias");
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
        $smarty->assign('categorias' , $categorias);
        $smarty->assign('producto' , $producto);
        $smarty->assign('id_producto' , $id_producto); 
        $smarty->display('./templates/formEditProducto.tpl');
    } 

    function showFormEditarCategoria($categoria){ 
        $smarty = new Smarty();
        $smarty->assign('titulo' , $this->titulo); 
        $smarty->assign('BASE_URL' , BASE_URL);
        $smarty->assign('position' , "categorias");
        $smarty->assign('categoria' , $categoria);
        $smarty->display('./templates/formEditcategoria.tpl');
    }

    function error($error=null,$insertCategoria=null,$update=null,$idCategoria=null){ 
        if($error==null){ 
            $error="Por favor complete todos los campos";
        }
        $this->html.=
            "<div class='container'>

            <h1>Error ".$error."</h1>
            <button type='button' class='btn btn-outline-danger'>
                <a class='btn btn-outline-danger btn-lg active' href=home>Home</a></button>";
        if($insertCategoria!=null){
            $this->html.="
            <button type='button' class='btn btn-outline-danger'>
                <a class='btn btn-outline-danger btn-lg active' href=Categorias>Categorias</a></button>"; 
        }
        if($update!=null){ 
            $this->html.="
            <button type='button' class='btn btn-outline-danger'>
                <a class='btn btn-outline-danger btn-lg active' href=".$update.$idCategoria.">Back</a></button>";
        }
        $this->html.=$this->finHtml; 
        echo $this->html;
    }

}