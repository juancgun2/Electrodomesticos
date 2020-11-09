<?php
require_once "./Model/modelComentario.php";
require_once "./Model/modelusers.php";
require_once "apiView.php";

class apiController{ 
    private $modelComentario;
    private $modelUsers;
    private $apiView; 
    private $data; 

    public function __construct() {
        $this->modelComentario = new modelComentario();
        $this->modelUsers= new modelUsers();
        $this->apiView = new apiView();
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
        $comentario= $this->modelComentario->getByIdProducto($id);
        if($comentario)
            return $this->apiView->response($comentario,200);
        else
            return $this->apiView->response("No existe el producto con id: $id o no hay comentarios
            asociados a el",404);
        
    }

    function agregarComentario($params=null){
        $data= $this->getData();
        $idUsuario = $this->modelUsers->getIdUser($data->usuario);
        $id=$this->modelComentario->agregarComentario($data->descripcion,$idUsuario->id_login,$data->idProducto,$data->puntuacion);
        $id=$id+0;
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
}