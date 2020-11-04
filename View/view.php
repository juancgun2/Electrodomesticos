<?php 
require_once 'libs/smarty/Smarty.class.php'; 
Class view{ 
    private $smarty;
    private $titulo;
    private $h1;

    function __construct(){ 
        $this->smarty = new Smarty();
        $this->titulo= "J&J Electrodomesticos";
    }

    function showAllItems($productos,$categorias=null,$sesion){  
        $this->smarty->assign('titulo' , $this->titulo); 
        $this->smarty->assign('BASE_URL' , BASE_URL); 
        $this->smarty->assign('position' , "home");
        $this->smarty->assign('productos' , $productos);
        $this->smarty->assign('categorias' , $categorias); 
        $this->smarty->assign('sesion' , $sesion);
        $this->smarty->display('./templates/formInsert.tpl');
    } 

    function showLogin($productos,$categorias=null,$sesion,$error=""){ 
        $this->smarty->assign('titulo' , $this->titulo); 
        $this->smarty->assign('BASE_URL' , BASE_URL); 
        $this->smarty->assign('position' , "notHome");
        $this->smarty->assign('productos' , $productos);
        $this->smarty->assign('categorias' , $categorias); 
        $this->smarty->assign('sesion' , $sesion);
        $this->smarty->assign('error' , $error);
        $this->smarty->display('./templates/login.tpl');
    }

    function showDetalleItem($detalle,$sesion){ 
        $this->smarty->assign('titulo' , $this->titulo); 
        $this->smarty->assign('BASE_URL' , BASE_URL);
        $this->smarty->assign('position' , "notHome");
        $this->smarty->assign('detalle' , $detalle); 
        $this->smarty->assign('sesion' , $sesion);
        $this->smarty->display('./templates/detalleItem.tpl');
    } 

    function showCategorias($categorias,$sesion){  
        $this->smarty->assign('titulo' , $this->titulo); 
        $this->smarty->assign('BASE_URL' , BASE_URL); 
        $this->smarty->assign('position' , "notHome");
        $this->smarty->assign('sesion' , $sesion);
        $this->smarty->assign('categorias' , $categorias); 
        $this->smarty->display('./templates/categorias.tpl');
    } 

    function redirectionCategorias(){ 
        header("Location: ".BASE_URL."Categorias");
    }

    function home($ruta=null){ 
        header("Location: ".BASE_URL.$ruta);
    } 

    function showFormEditar($id_producto,$categorias,$producto,$sesion){ 
        $this->smarty->assign('titulo' , $this->titulo); 
        $this->smarty->assign('BASE_URL' , BASE_URL); 
        $this->smarty->assign('position' , "notHome");
        $this->smarty->assign('categorias' , $categorias);
        $this->smarty->assign('producto' , $producto);
        $this->smarty->assign('sesion' , $sesion);
        $this->smarty->assign('id_producto' , $id_producto); 
        $this->smarty->display('./templates/formEditProducto.tpl');
    } 

    function showFormEditarCategoria($categoria,$sesion){ 
        $this->smarty->assign('titulo' , $this->titulo); 
        $this->smarty->assign('BASE_URL' , BASE_URL);
        $this->smarty->assign('position' , "notHome");
        $this->smarty->assign('categoria' , $categoria);
        $this->smarty->assign('sesion' , $sesion);
        $this->smarty->display('./templates/formEditcategoria.tpl');
    }

    function error($error=null,$insertCategoria=null,$update=null,$id=null,$sesion){ 
        if($error==null){ 
            $error="Por favor complete todos los campos";
        }
        if($insertCategoria!=null && $update==null){
            $this->smarty->assign('titulo' , $this->titulo); 
            $this->smarty->assign('BASE_URL' , BASE_URL);
            $this->smarty->assign('position' , "error"); 
            $this->smarty->assign('error' , $error);
            $this->smarty->assign('categoria' , "");
            $this->smarty->assign('update' , "Categorias");
            $this->smarty->assign('id' , ""); 
            $this->smarty->assign('sesion' , $sesion);
            $this->smarty->display('./templates/header.tpl');
        }elseif ($update!=null){ 
            $this->smarty->assign('titulo' , $this->titulo); 
            $this->smarty->assign('BASE_URL' , BASE_URL);
            $this->smarty->assign('position' , "error"); 
            $this->smarty->assign('error' , $error);
            $this->smarty->assign('categoria' , "");
            $this->smarty->assign('update' , $update);
            $this->smarty->assign('id' , $id);
            $this->smarty->assign('sesion' , $sesion);
            $this->smarty->display('./templates/header.tpl');
        }
    }

    function renderUsuarios($productos,$categorias,$sesion,$usuarios){
        $this->smarty->assign('titulo' , $this->titulo); 
        $this->smarty->assign('BASE_URL' , BASE_URL); 
        $this->smarty->assign('position' , "home");
        $this->smarty->assign('productos' , $productos);
        $this->smarty->assign('categorias' , $categorias); 
        $this->smarty->assign('sesion' , $sesion);
        $this->smarty->assign("usuarios" , $usuarios);
        $this->smarty->display('./templates/usuarios.tpl');
    }

}