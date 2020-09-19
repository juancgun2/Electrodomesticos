<?php 

Class view{ 
    private $titulo;
    private $html; 
    private $finHtml;

    function __construct(){ 
        $this->titulo= "J&J Electrodomesticos";
        $this->html='<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
            integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
            <title>"'.$this->titulo.'"</title>
        </head>
        <body>';
        $this->finHtml='<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        </body>
        </html> ';
    }

    function showAllItems($productos,$categorias){ 
        $this->html.='
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <button type="button" class="btn btn-secondary"><a href='.BASE_URL.'Categorias>Categorias</a></button>
            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" 
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Mostrar Por Categorias
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">'; 
                foreach($categorias as $categoria){
                    $this->html.='<a class="dropdown-item" href='.BASE_URL.'Categoria/'.$categoria->id.'>'.$categoria->name.'</a>';
                }
                $this->html.='
                </div>
            </div>
        </div>';
        $this->html.="<table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Categoria</th>
                <th>Ver detalle</th>
            </tr>
        <thead>
        <tbody>";
        foreach($productos as $producto) {
        $this->html.= "
            <tr>
                <td>$producto->nombre</td>
                <td>$producto->precio</td>
                <td>$producto->stock</td> 
                <td>$producto->name</td> 
                <td><button type='button'><a href=".BASE_URL."verDetalle/".$producto->id.">Detalle</a></button></td>  
            </tr>";
        }
        $this->html.= " </tbody>    
        </table>"; 
        $this->html.=$this->finHtml;
        echo $this->html;
    } 

    function showDetalleItem($detalles){ 
        $this->html.="<table>
        <thead>
            <tr>
                <th>id-Producto</th>
                <th>Producto</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Categoria</th>
            </tr>
        <thead>
        <tbody>";
        foreach($detalles as $detalle) {
        $this->html.= "
            <tr>
                <td>$detalle->id</td>
                <td>$detalle->nombre</td>
                <td>**</td> 
                <td>$detalle->precio</td> 
                <td>$detalle->stock</td> 
                <td>$detalle->name</td>  
            </tr>";
        }
        $this->html.= " </tbody>    
        </table>"; 
        echo $this->html; 
        //**=$detalle->descripcion
    } 

    function showCategorias($categorias){ 
        $this->html.=" <h1> Lista de categorias </h1>
            <ul>"; 
            foreach($categorias as $categoria){ 
                $this->html.="<li>$categoria->name</li>";
            } 
            "</ul>";
            echo $this->html;
    } 

    function home(){ 
        header("Location: ".BASE_URL."");
    } 

}