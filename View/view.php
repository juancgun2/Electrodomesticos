<?php 
// <base href="'.BASE_URL.'"> todos los href tienen base_url como base de la url 
Class view{ 
    private $titulo;
    private $html; 
    private $finHtml;
    private $formInsertProducto;
    private $formUpdateProducto;

    function __construct(){ 
        $this->titulo= "J&J Electrodomesticos";
        $this->html='<!DOCTYPE html>
            <html lang="en">
            <head> 
            <base href="'.BASE_URL.'">
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
            integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
            <title>'.$this->titulo.'</title>
            </head>
            <body> 
            <h1>'.$this->titulo.'</h1>'; 
        $this->finHtml='<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        </body>
        </html> ';
    }

    function showAllItems($productos,$categorias){ 
        $this->html.='
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <button type="button" class="btn btn-secondary"><a class="btn btn-secondary" 
             href=Categorias>Categorias</a></button>
            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" 
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Mostrar Por Categorias
                </button>
                <div class="dropdown-menu list-group-item-warning" aria-labelledby="btnGroupDrop1">'; 
                foreach($categorias as $categoria){
                    $this->html.='<a class="dropdown-item"
                         href=Categoria/'.$categoria->id.'>'.$categoria->name.'</a>';
                }   
                $this->html.=
                '<a class="dropdown-item" href=home>Todas</a>
                </div>
            </div>
        </div>';
        $this->html.="<table class='table table-hover table-dark'>
        <thead>
            <tr>
                <th scope='col'>Producto</th>
                <th scope='col'>Precio</th>
                <th scope='col'>Stock</th>
                <th scope='col'>Categoria</th>
                <th scope='col'>Ver detalle</th> 
                <th scope='col'>Editar</th>
                <th scope='col'>Eliminar</th>
            </tr>
        </thead>
        <tbody>";
        foreach($productos as $producto) {
        $this->html.= "
            <tr>
                <th scope='col'>$producto->nombre</th>
                <td>$producto->precio</td>
                <td>$producto->stock</td> 
                <td>$producto->name</td> 
                <td><button class='btn btn-secondary' type='button'><a class='btn btn-secondary btn-lg active'
                 href=verDetalle/".$producto->id.">Detalle</a></button></td> 
                 <td><button class='btn btn-secondary' type='button'><a class='btn btn-warning btn-lg active'
                 href=formEditar/".$producto->id.">Editar</a></button></td> 
                <td><button class='btn btn-secondary' type='button'><a class='btn btn-outline-danger btn-lg active'
                href=eliminarProducto/".$producto->id.">Eliminar</a></button></td>
            </tr>";
        }
        $this->html.= " </tbody>    
        </table>"; 
        $this->formInsertProducto=' 
            <div class="container">
            <h1> Insertar Producto </h1>
                <form action="insertProducto" method="POST">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="nombre">
                </div>
                <div class="form-group">
                    <label>Descripcion</label>
                    <input type="text" class="form-control" name="descripcion">
                </div>
                <div class="form-group">
                    <label>Precio</label>
                    <input type="text" class="form-control" name="precio">
                </div>
                <div class="form-group">
                    <label>Stock</label>
                    <input type="text" class="form-control" name="stock" >
                </div>
                <div class="form-group">
                    <label>Categoria</label>
                    <select name="nameCategoria" class="form-control">';
                        foreach($categorias as $categoria){
                        $this->formInsertProducto.='<option>'.$categoria->name.'</option>'; 
                        }
                        $this->formInsertProducto.=        
                    '</select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                </form> 
            </div>';
        $this->html.=$this->formInsertProducto;
        $this->html.=$this->finHtml;
        echo $this->html;
    } 

    function showDetalleItem($detalle){ 
        $this->html.="
        <div class='container'>
            <div class='row'> 
                <div class='col'>
                    <h1> Detalle del producto </h1>   
                </div> 
                <div class='col'>              
                    <button type='button' class='btn btn-outline-danger'>
                    <a class='btn btn-outline-danger btn-lg active' href=home>Home</a></button>
                </div>
            </div>
        </div>
        <table class='table table-hover table-dark'>
        <thead>
            <tr>
                <th scope='col'>id-Producto</th>
                <th scope='col'>Producto</th>
                <th scope='col'>Descripcion</th>
                <th scope='col'>Precio</th>
                <th scope='col'>Stock</th>
                <th scope='col'>Categoria</th>
            </tr>
        <thead>
        <tbody>"; 
        $this->html.= "
            <tr>
                <th scope='row'>$detalle->id</th>
                <td>$detalle->nombre</td>
                <td>$detalle->descripcion</td> 
                <td>$detalle->precio</td> 
                <td>$detalle->stock</td> 
                <td>$detalle->name</td>  
            </tr>";
        $this->html.= " </tbody>    
        </table>"; 
        echo $this->html; 
    } 

    function showCategorias($categorias){ 
        $this->html.=" 
        <div class='container'>
            <div class='row'> 
                <div class='col'>
                    <h1> Lista de categorias </h1>
                </div> 
                <div class='col'>
                    <button type='button' class='btn btn-outline-danger'>
                    <a class='btn btn-outline-danger btn-lg active' href=home>Home</a></button>
                </div> 
            </div>
        </div> 
        <div class='container'>
            <table class='table table-sm table-hover'>
                <thead>
                    <tr>
                        <th scope='col'>Nombre</th>
                        <th scope='col'>Editar</th>
                        <th scope='col'>Eliminar</th>
                    </tr>
                </thead>
                <tbody>";
                    foreach($categorias as $categoria){ 
                    $this->html.="
                    <tr>
                        <th>$categoria->name</th>
                        <td><button class='btn' type='button'>
                            <a class='btn btn-warning'
                            href=formEditarCategoria/".$categoria->id.">Editar</a></button></td> 
                        <td ><button class='btn'
                            type='button'><a class='btn btn-danger'
                            href=eliminarCategoria/".$categoria->id.">Eliminar</a></button></td>
                    </tr>";
                } 
                $this->html.="</tbody>
            </table>
        </div>";
        $this->html.=
        '<div class="container">
            <h1> Insertar Categoria </h1>
                <form action="insertCategoria" method="POST">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" name="nombreCategoria">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form> 
        </div>'; 
            $this->html.=$this->finHtml;
            echo $this->html;
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
        $this->formUpdateProducto=$this->html;
        $this->formUpdateProducto.= 
        '<div class="container">
            <div class="row"> 
                <div class="col">
                    <h1> Editar producto '.$producto->nombre.' </h1>   
                </div> 
            </div>    
                <form action="editar" method="POST">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="hidden" name="id_producto" value="'.$id_producto.'">
                    <input type="text" class="form-control" value="'.$producto->nombre.'" 
                        name="nombre" placeholder="'.$producto->nombre.'">
                </div>
                <div class="form-group">
                    <label> Descripcion </label>
                    <input class="form-control" value="'.$producto->descripcion.'"
                         name="descripcion" type="text" placeholder="'.$producto->descripcion.'">
                </div>
                <div class="form-group">
                    <label>Precio</label>
                    <input placeholder='.$producto->precio.' value="'.$producto->precio.'"
                         name="precio" class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label>Stock</label>
                    <input placeholder='.$producto->stock.' value="'.$producto->stock.'" 
                        type="text" class="form-control" name="stock">
                </div>
                <div class="form-group">
                    <label>Categoria</label>
                    <select name="nameCategoria" class="form-control">';
                        foreach($categorias as $categoria){
                        $this->formUpdateProducto.='<option>'.$categoria->name.'</option>'; 
                        }
                        $this->formUpdateProducto.=        
                    '</select>
                </div> 
                <div class="row"> 
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Submit</button>         
                        <button type="button" class="btn">
                        <a class="btn btn-danger" href=home>Cancelar</a></button>
                    </div> 
                </div>    
                </form> 
        </div>';
        $this->formUpdateProducto.=$this->finHtml; 
        echo $this->formUpdateProducto;    
    } 

    function showFormEditarCategoria($categoria){ 
        $this->html.='<div class="container">
            <div class="row"> 
                <div class="col">
                    <h1> Editar categoria '.$categoria->name.' </h1>   
                </div> 
            </div>    
                <form action="editarCategoria" method="POST">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="hidden" name="id_categoria" value="'.$categoria->id.'">
                    <input type="text" class="form-control" value="'.$categoria->name.'" 
                        name="nombreCategoria" placeholder="'.$categoria->name.'">
                </div> 
                <div class="row"> 
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Submit</button>         
                        <button type="button" class="btn">
                        <a class="btn btn-danger" href=Categorias>Cancelar</a></button>
                    </div> 
                </div>    
                </form> 
        </div>'; 
        $this->html.=$this->finHtml; 
        echo $this->html;
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