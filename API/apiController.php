<?php
require_once "./Model/modelComentario.php";

class apiController{ 
    private $modelComentario;
    private $apiView; 
    private $data; 

    public function __construct() {
        $this->modelComentario = new modelComentario();
        $this->apiView = new apiView();
        $this->data = file_get_contents("php://input"); 
    }

    function getData(){ 
        return json_decode($this->data); 
    }  

    function getComentarios(){
        $this->apiView->response($this->modelComentario->getComentarios(),200);
    }

    function getComentario($params=null){
        $id=$params[":ID"];
        $comentario= $this->modelComentario->getComentario($id);
        if($comentario){
            return $this->view->response($comentario,200);
        else
            return $this->view->response("No existe el comentario con id: $id",404);
        }
    }

    function agregarComentario($params=null){
        $data= $this->getData();
        $id=$this->modelComentario->agregarComentario($data->descripcion,$data->idUsuario,$data->idProducto,$data->puntuacion);
        if($id)
            return $this->view->response($this->modelComentario->getComentario($id),200);
        else 
            return $this->view->response("No se puedo agregar,intente mas tarde",500);
    }

    function eliminarComentario($params=null){
        $id=$params[":ID"];
        $comentario= $this->getComentario($id);
        if($comentario){
            $query=$this->modelComentario->eliminarComentario($id);
            if($query>0)
                return $this->view->response("El comentario fue eliminado",200);
            else 
                return $this->view->response("No se pudo eliminar el comentario, intente mas tarde",500);
        }else
            return $this->view->responses("El id $id es invalido",404);
    }


}