<?php
require_once "./Model/modelComentario.php";
require_once "./Model/modelProducto.php";
require_once "./Model/modelusers.php";
require_once "apiView.php";

class apiController{ 
    private $modelComentario;
    private $modelProducto;
    private $apiView; 
    private $data; 

    public function __construct() {
        $this->modelComentario = new modelComentario();
        $this->apiView = new apiView();
        $this->modelProducto = new modelProducto();
        $this->data = file_get_contents("php://input"); 
    }

    function getData(){ 
        return json_decode($this->data); 
    }  

    function getAllComentarios(){
        $comentarios=$this->modelComentario->getAllComentarios();
        if($comentarios)
            $this->apiView->response($comentarios,200);
        else 
            $this->apiView->response("Error en el servidor,intente mas tarde",500);
    }

    function getByIdProducto($params=null){
        $id=$params[":ID"];
<<<<<<< HEAD
        if($this->existeProducto($id)){
                return $this->apiView->response($this->modelComentario->getByIdProducto($id),200);
        }else{ 
            return $this->apiView->response("No existe el producto con id: $id",404);
        }
=======
        $comentario= $this->modelComentario->getByIdProducto($id);
        if($comentario)
            return $this->apiView->response($comentario,200);
        else
            return $this->apiView->response("No existe el producto con id: $id o no hay comentarios
            asociados a el",404);
        
>>>>>>> bc180352877652de712e7f780b635821dec7664e
    }

    function agregarComentario($params=null){
        $data= $this->getData();
<<<<<<< HEAD
        $id=$this->modelComentario->agregarComentario($data->descripcion,$data->idUsuario,$data->idProducto,$data->puntuacion);
=======
        $idUsuario = $this->modelUsers->getIdUser($data->usuario);
        $id=$this->modelComentario->agregarComentario($data->descripcion,$idUsuario->id_login,$data->idProducto,$data->puntuacion);
        $id=$id+0;
>>>>>>> bc180352877652de712e7f780b635821dec7664e
        if($id)
            return $this->apiView->response($this->modelComentario->getComentarioById($id),200);
        else 
            return $this->apiView->response("No se puedo agregar,intente mas tarde",500);
    }

    function eliminarComentario($params=null){
        $id=$params[":ID"];
        $comentario= $this->modelComentario->getComentarioById($id);
        if($comentario){
            $query=$this->modelComentario->eliminarComentario($id);
            if($query>0)
                return $this->apiView->response("El comentario fue eliminado",200);
            else 
                return $this->apiView->response("No se pudo eliminar el comentario, intente mas tarde",500);
        }else
            return $this->apiView->response("El id $id es invalido",404);
    }
<<<<<<< HEAD

    function existeProducto($id){
        $producto = $this->modelProducto->getItem($id);
        if($producto === false)
            return false;
        else
            return true;
    }
=======
>>>>>>> bc180352877652de712e7f780b635821dec7664e
}