<?php 
require_once 'libs/smarty/Smarty.class.php'; 
Class view{ 
    private $smarty;
    private $titulo;
    private $h1;

    function __construct(){ 
        $this->titulo= "J&J Electrodomesticos";
    }

    function showAllItems($productos,$categorias=null,$sesion){ 
        $smarty = new Smarty(); 
        $smarty->assign('titulo' , $this->titulo); 
        $smarty->assign('BASE_URL' , BASE_URL); 
        $smarty->assign('position' , "home");
        $smarty->assign('productos' , $productos);
        $smarty->assign('categorias' , $categorias); 
        $smarty->assign('sesion' , $sesion);
        $smarty->display('./templates/formInsert.tpl');
    } 

    function showLogin($productos,$categorias=null,$sesion,$error=""){ 
        $smarty = new Smarty(); 
        $smarty->assign('titulo' , $this->titulo); 
        $smarty->assign('BASE_URL' , BASE_URL); 
        $smarty->assign('position' , "notHome");
        $smarty->assign('productos' , $productos);
        $smarty->assign('categorias' , $categorias); 
        $smarty->assign('sesion' , $sesion);
        $smarty->assign('error' , $error);
        $smarty->display('./templates/login.tpl');
    }

    function showDetalleItem($detalle,$sesion){ 
        $smarty = new Smarty();
        $smarty->assign('titulo' , $this->titulo); 
        $smarty->assign('BASE_URL' , BASE_URL);
        $smarty->assign('position' , "notHome");
        $smarty->assign('detalle' , $detalle); 
        $smarty->assign('sesion' , $sesion);
        $smarty->display('./templates/detalleItem.tpl');
    } 

    function showCategorias($categorias,$sesion){  
        $smarty = new Smarty();
        $smarty->assign('titulo' , $this->titulo); 
        $smarty->assign('BASE_URL' , BASE_URL); 
        $smarty->assign('position' , "notHome");
        $smarty->assign('sesion' , $sesion);
        $smarty->assign('categorias' , $categorias); 
        $smarty->display('./templates/categorias.tpl');
    } 

    function redirectionCategorias(){ 
        header("Location: ".BASE_URL."Categorias");
    }

    function home($ruta=null){ 
        header("Location: ".BASE_URL.$ruta);
    } 

    function showFormEditar($id_producto,$categorias,$producto,$sesion){ 
        $smarty = new Smarty();
        $smarty->assign('titulo' , $this->titulo); 
        $smarty->assign('BASE_URL' , BASE_URL); 
        $smarty->assign('position' , "notHome");
        $smarty->assign('categorias' , $categorias);
        $smarty->assign('producto' , $producto);
        $smarty->assign('sesion' , $sesion);
        $smarty->assign('id_producto' , $id_producto); 
        $smarty->display('./templates/formEditProducto.tpl');
    } 

    function showFormEditarCategoria($categoria,$sesion){ 
        $smarty = new Smarty();
        $smarty->assign('titulo' , $this->titulo); 
        $smarty->assign('BASE_URL' , BASE_URL);
        $smarty->assign('position' , "notHome");
        $smarty->assign('categoria' , $categoria);
        $smarty->assign('sesion' , $sesion);
        $smarty->display('./templates/formEditcategoria.tpl');
    }

    function error($error=null,$insertCategoria=null,$update=null,$id=null,$sesion){ 
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
            $smarty->assign('sesion' , $sesion);
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
            $smarty->assign('sesion' , $sesion);
            $smarty->display('./templates/header.tpl');
        }
    }

}