<?php 
require_once "./View/view.php"; 
require_once "./Model/modelProducto.php"; 
require_once "./Model/modelCategorias.php";
require_once "./Model/modelUsers.php";
require_once "./Model/modelImagen.php";
require_once "./Helper/helper.php";

Class adminController{ 
    private $modelProducto;
    private $modelCategorias; 
    private $modelUsers;
    private $modelImagen;
    private $view;
    private $helper;

    function __construct(){ 
        $this->modelProducto = new modelProducto(); 
        $this->modelCategorias = new modelCategorias;
        $this->modelUsers = new modelUsers(); 
        $this->modelImagen = new modelImagen(); 
        $this->view= new view();
        $this->helper = new helper();
    } 

    private function getImgName($tempName , $realName) {
        $path = "img/img_productos/" . uniqid("", true) . ".". strtolower(pathinfo($realName,PATHINFO_EXTENSION));
        move_uploaded_file($tempName, $path);
        return $path;
    }

    private function controlarExtensionImagen() { 
        if($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg"
                 || $_FILES['imagen']['type'] == "image/png")
            return true; 
        else 
            return false;
    }

    /*function moveAndInsertImg($idProducto){ 
        foreach($_FILES["imagen"]["tmp_name"] as $key => $tmp_name) {
            $name = $_FILES["imagen"]["name"][$key];
            print_r($name); 
            die();
            $path = $this->getImgName($key , $name);
            print_r($name);
            print_r($path);
            die();
            $this->modelImagen->insertarImagen($idProducto,$path);
        }
    }*/
    //if (!empty($_FILES['image']))

    function insertarProducto(){ 
        if($this->helper->getRol() === 'admin') {
            if($this->helper->getActivity()) {
                if(!empty($_POST["nombre"]) && !empty($_POST["descripcion"]) && !empty($_POST["precio"]) &&
                    !empty($_POST["stock"]) && !empty($_POST["nameCategoria"])){ 
                    $nombre = $_POST["nombre"]; 
                    $descripcion = $_POST["descripcion"]; 
                    $precio = $_POST["precio"]; 
                    $stock = $_POST["stock"]; 
                    $nombreCategoria = $_POST["nameCategoria"]; 
                    $pathImg = $this->getImgName($_FILES["imagen"]["tmp_name"],$_FILES["imagen"]["name"]);
                    $id_categoria = $this->modelCategorias->getIdCategoria($nombreCategoria);
                    if(!$this->existeProducto($nombre,$precio,$descripcion,$id_categoria->id)&&$this->controlarExtensionImagen()){
                        $idProducto = $this->modelProducto->insertarProducto($nombre,$descripcion,$precio,$stock,$id_categoria->id); 
                        $pathImg = $this->getImgName($_FILES["imagen"]["tmp_name"],$_FILES["imagen"]["name"]);
                        $this->modelImagen->insertarImagen($idProducto,$pathImg);
                    }else{ 
                        $idProducto = $this->modelProducto->getIdProducto($nombre,$precio,$descripcion,$id_categoria->id);
                        $producto = $this->modelProducto->getItem($idProducto->id);
                        $stock = $stock + $producto->stock;
                        $this->modelProducto->setStock($idProducto->id,$stock);
                    } 
                    $this->view->home();          
                }else{ 
                    $this->view->error(null, true, "home", "", "admin", $this->helper->getEmail());
                }
            }else{ 
                $this->helper->caducoSesion();
            }
        }else
            $this->helper->accesoDenegado();
    } 

    function eliminarProducto($params=null) { 
        if($this->helper->getRol() === 'admin'){
            if($this->helper->getActivity()) {
                $id_producto = $params[":ID"]; 
                $this->modelProducto->eliminarProducto($id_producto);
                $this->view->home(); 
            } else
                $this->helper->caducoSesion();
        }else
            $this->helper->accesoDenegado();
    } 

    function showFormEditar($params=null) { 
        if($this->helper->getRol() === 'admin') {
            if($this->helper->getActivity()) {
                $id_producto = $params[":ID"]; 
                $categorias = $this->modelCategorias->getCategorias(); 
                $producto = $this->modelProducto->getItem($id_producto);
                $this->view->showFormEditar($id_producto, $categorias, $producto, "admin", $this->helper->getEmail());
            } else
                $this->helper->caducoSesion();
        }else
            $this->helper->accesoDenegado();
    }

    function editarProducto(){ 
        if($this->helper->getRol() === 'admin') {
            if($this->helper->getActivity()) {
                $idProducto = $_POST["id_producto"];
                if(!empty($_POST["nombre"]) && !empty($_POST["descripcion"]) && !empty($_POST["precio"]) 
                        && !empty($_POST["stock"]) && !empty($_POST["nameCategoria"])) {     
                    $nombre = $_POST["nombre"]; 
                    $descripcion = $_POST["descripcion"]; 
                    $precio = $_POST["precio"];
                    $stock = $_POST["stock"];
                    $nombreCategoria = $_POST["nameCategoria"]; 
                    $idProducto = $_POST["id_producto"];
                    $idCategoria = $this->modelCategorias->getIdCategoria($nombreCategoria);
                    if ($this->controlarExtensionImagen()) {
                        $pathImg = $this->getImgName($_FILES["imagen"]["tmp_name"],$_FILES["imagen"]["name"]);
                        $this->modelImagen->insertarImagen($idProducto , $pathImg);
                    }
                    if(!$this->existeProducto($nombre, $precio, $descripcion, $idCategoria->id)){
                        $this->modelProducto->editarProducto($idProducto, $nombre, $descripcion, $precio, $stock, $idCategoria->id);
                        $this->view->home(); 
                    } else  {
                        $error="El producto ingresado ya existe"; 
                        $this->view->error($error, null, "formEditar/", $idProducto, "admin", $this->helper->getEmail());
                        }
                }else
                    $this->view->error(null, null, "formEditar/", $idProducto, "admin", $this->helper->getEmail());
            } else
                $this->helper->caducoSesion();
        }else 
            $this->helper->accesoDenegado();
    } 

    function showFormEditarCategoria($params=null){ 
        if($this->helper->getRol() === 'admin'){
            if($this->helper->getActivity()){
                $nombreCategoria = $params[":NOMBRE"]; 
                $id_categoria = $this->modelCategorias->getIdCategoria($nombreCategoria); 
                $this->view->showFormEditarCategoria($this->modelCategorias->getCategoria($id_categoria->id), "admin", $this->helper->getEmail());
            } else
                $this->helper->caducoSesion();
        }else  
            $this->helper->accesoDenegado();
    } 

    function editarCategoria(){ 
        if($this->helper->getRol() === 'admin') {
            if($this->helper->getActivity()) {
                $id_categoria = $_POST["id_categoria"];
                $nombreAnterior = $this->modelCategorias->getCategoria($id_categoria);
                if(!empty($_POST["nombreCategoria"])){ 
                    $nombreCategoria = $_POST["nombreCategoria"]; 
                    if(!$this->existeCategoria($nombreCategoria)) {
                        $this->modelCategorias->editarCategoria($id_categoria, $nombreCategoria); 
                        $this->view->home('Categorias');
                    } else { 
                        $error="La categoria ingresada ya existe";
                        $this->view->error($error, true, "formEditarCategoria/", $nombreCategoria, "admin", $this->helper->getEmail());
                    }    
                } else  
                    $this->view->error(null, null, "formEditarCategoria/", $nombreAnterior->name, "admin", $this->helper->getEmail());
            } else
                $this->helper->caducoSesion();
        } else 
            $this->helper->accesoDenegado();
    } 

    function eliminarCategoria($params=null){ 
        if($this->helper->getRol() === 'admin'){
            if($this->helper->getActivity()){
                $nombreCategoria = $params[":NOMBRE"]; 
                $id_categoria = $this->modelCategorias->getIdCategoria($nombreCategoria); 
                $this->modelCategorias->eliminarCategoria($id_categoria->id); 
                $this->view->redirectionCategorias();
            } else 
                $this->helper->caducoSesion();
        } else
            $this->helper->accesoDenegado();
    }

    private function existeProducto($nombre, $precio, $descripcion, $idCategoria){ 
        $producto = $this->modelProducto->getIdProducto($nombre, $precio, $descripcion, $idCategoria);
        if ($producto === false)
            return false;
        else
            return true;
    }

    private function existeCategoria($nombre){ 
        $idCategoria = $this->modelCategorias->getIdCategoria($nombre); 
        if ($idCategoria === false) 
            return false;
        else  
            return true;
    }

    function insertarCategoria(){ 
        if($this->helper->getRol() === 'admin'){
            if($this->helper->getActivity()){
                if(!empty($_POST["nombreCategoria"])){
                    $nombre = $_POST["nombreCategoria"];
                    if(!$this->existeCategoria($nombre)){  
                        $this->modelCategorias->insertarCategoria($nombre); 
                        $this->view->redirectionCategorias();
                    }else{ 
                        $error="La categoria ingresada ya existe";
                        $this->view->error($error, true, null, null, "admin", $this->helper->getEmail());
                    }
                } else 
                    $this->view->error(null, true, null, null, "admin", $this->helper->getEmail());
            } else
                $this->helper->caducoSesion();
        } else 
            $this->helper->accesoDenegado();
    } 

    function showUsuarios() {
        if($this->helper->getRol() === 'admin') {
            if($this->helper->getActivity()) 
                $this->view->renderUsuarios("admin", $this->modelUsers->getUsuarios(), $this->helper->getEmail());
            else 
                $this->helper->caducoSesion();
        } else 
            $this->helper->accesoDenegado();
    }

    function eliminarUsuario($params=null){
        if($this->helper->getRol() === 'admin') {
            if($this->helper->getActivity()) {
                $idUsuario = $params[":ID"];
                $this->modelUsers->eliminarUsuario($idUsuario);
                $this->view->home("Usuarios");
            } else  
                $this->helper->caducoSesion();
        } else  
            $this->helper->accesoDenegado();
        
    }

    function setAdmin($params=null){
        if($this->helper->getRol() === 'admin') {
            if($this->helper->getActivity()) {
                $id = $params[":ID"];
                $this->modelUsers->setAdmin($id);
                $this->view->home("Usuarios");
            } else 
                $this->helper->caducoSesion();
        } else 
            $this->helper->accesoDenegado();
    }

    function setUser($params=null) { 
        if($this->helper->getRol() === 'admin') {
            if($this->helper->getActivity()) {
                $id = $params[":ID"]; 
                $this->modelUsers->setUser($id);
                $this->view->home("Usuarios");
            } else 
                $this->helper->caducoSesion();
        } else 
            $this->helper->accesoDenegado(); 
    }

    function eliminarImagen($params=null){ 
        if($this->helper->getRol() === 'admin') {
            if($this->helper->getActivity()) {
                $idImagen=$params[":ID"];
                $this->modelImagen->eliminarImagen($idImagen);
                $this->view->home();
            } else 
                $this->helper->caducoSesion();
        } else 
            $this->helper->accesoDenegado();
    }
}
