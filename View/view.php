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

    function showAllItems($productos,$categorias,$sesion,$imagenes,$email=null,$pagina, $nextPage){  
        $this->smarty->assign('titulo' , $this->titulo); 
        $this->smarty->assign('BASE_URL' , BASE_URL); 
        $this->smarty->assign('position' , "home");
        $this->smarty->assign('productos' , $productos);
        $this->smarty->assign('categorias' , $categorias); 
        $this->smarty->assign('sesion' , $sesion);
        $this->smarty->assign('email' , $email);
        $this->smarty->assign('imagenes' , $imagenes);
        $this->smarty->assign('size' , count($productos)-1); //size del arreglo productos para iterarlo junto al de imagenes en smarty
        $this->smarty->assign('pagina' , $pagina); //paginacion 
        $this->smarty->assign('nextPage' , $nextPage);
        $this->smarty->display('./templates/formInsert.tpl');
    } 

    function showLogin($sesion,$email=null,$error=""){ 
        $this->smarty->assign('titulo' , $this->titulo); 
        $this->smarty->assign('BASE_URL' , BASE_URL); 
        $this->smarty->assign('position' , "notHome");
        $this->smarty->assign('sesion' , $sesion);
        $this->smarty->assign('email' , $email);
        $this->smarty->assign('error' , $error);
        $this->smarty->display('./templates/login.tpl');
    }

    function showDetalleItem($detalle,$sesion,$email=null,$idUsuario=null,$imagenes){ 
        $this->smarty->assign('titulo' , $this->titulo); 
        $this->smarty->assign('BASE_URL' , BASE_URL);
        $this->smarty->assign('position' , "notHome");
        $this->smarty->assign('detalle' , $detalle); 
        $this->smarty->assign('sesion' , $sesion);
        $this->smarty->assign('email' , $email);
        $this->smarty->assign('idUsuario' , $idUsuario);
        $this->smarty->assign('imagenes' , $imagenes);
        $this->smarty->display('./templates/detalleItem.tpl');
    } 

    function showCategorias($categorias,$sesion,$email=null){  
        $this->smarty->assign('titulo' , $this->titulo); 
        $this->smarty->assign('BASE_URL' , BASE_URL); 
        $this->smarty->assign('position' , "notHome");
        $this->smarty->assign('sesion' , $sesion);
        $this->smarty->assign('email' , $email);
        $this->smarty->assign('categorias' , $categorias); 
        $this->smarty->display('./templates/categorias.tpl');
    } 

    function home($ruta=""){ 
        header("Location: ".BASE_URL.$ruta);
    } 

    function showFormEditar($id_producto,$categorias,$producto,$sesion,$email){ 
        $this->smarty->assign('titulo' , $this->titulo); 
        $this->smarty->assign('BASE_URL' , BASE_URL); 
        $this->smarty->assign('position' , "notHome");
        $this->smarty->assign('categorias' , $categorias);
        $this->smarty->assign('producto' , $producto);
        $this->smarty->assign('sesion' , $sesion);
        $this->smarty->assign('email' , $email);
        $this->smarty->assign('id_producto' , $id_producto); 
        $this->smarty->display('./templates/formEditProducto.tpl');
    } 

    function showFormEditarCategoria($categoria,$sesion,$email){ 
        $this->smarty->assign('titulo' , $this->titulo); 
        $this->smarty->assign('BASE_URL' , BASE_URL);
        $this->smarty->assign('position' , "notHome");
        $this->smarty->assign('categoria' , $categoria);
        $this->smarty->assign('sesion' , $sesion);
        $this->smarty->assign('email' , $email);
        $this->smarty->display('./templates/formEditcategoria.tpl');
    }

    function error($error=null,$insertCategoria=null,$update=null,$id=null,$sesion,$email){ 
        if($error==null){ 
            $error="Por favor complete todos los campos";
        }
        //posicion donde se desarrolla el error: insertar categoria
        if($insertCategoria!=null && $update==null){
            $this->smarty->assign('titulo' , $this->titulo); 
            $this->smarty->assign('BASE_URL' , BASE_URL);
            $this->smarty->assign('position' , "error"); 
            $this->smarty->assign('error' , $error);
            $this->smarty->assign('categoria' , "");
            $this->smarty->assign('update' , "Categorias");
            $this->smarty->assign('id' , ""); 
            $this->smarty->assign('sesion' , $sesion);
            $this->smarty->assign('email' , $email);
            $this->smarty->display('./templates/header.tpl');
        }elseif ($update!=null){ //posicion donde se desarrolla el error: actualizar producto/categoria
            $this->smarty->assign('titulo' , $this->titulo); 
            $this->smarty->assign('BASE_URL' , BASE_URL);
            $this->smarty->assign('position' , "error"); 
            $this->smarty->assign('error' , $error);
            $this->smarty->assign('categoria' , "");
            $this->smarty->assign('update' , $update);
            $this->smarty->assign('id' , $id);
            $this->smarty->assign('sesion' , $sesion);
            $this->smarty->assign('email' , $email);
            $this->smarty->display('./templates/header.tpl');
        }
    }

    function renderUsuarios($sesion,$usuarios,$email){
        $this->smarty->assign('titulo' , $this->titulo); 
        $this->smarty->assign('BASE_URL' , BASE_URL); 
        $this->smarty->assign('position' , "notHome"); 
        $this->smarty->assign('sesion' , $sesion);
        $this->smarty->assign('email' , $email);
        $this->smarty->assign("usuarios" , $usuarios);
        $this->smarty->display('./templates/usuarios.tpl');
    }

}