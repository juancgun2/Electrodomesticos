<!DOCTYPE html>
    <html lang="en">
    <head> 
    <base href="{$BASE_URL}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="./css/estilo.css"> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>{$titulo}</title>
    </head>
    <body> 
        <header class="logo">
            <h1 class="nameLogo"><span id="jyj">J&J</span> Electrodomesticos</h1>   
        </header> 
            <div class="background">
            {if $position == "home"} 
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <button type="button" class="btn btn-secondary"><a class="btn btn-secondary" 
                    href="Categorias">Categorias</a></button>  
                <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" 
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Mostrar Por Categorias
                    </button>
                    <div class="dropdown-menu list-group-item-warning" aria-labelledby="btnGroupDrop1"> 
                        {foreach from=$categorias item=categoria}
                            <a class="dropdown-item"href="Categoria/{$categoria->name}">{$categoria->name}</a>
                        {/foreach}   
                        <a class="dropdown-item" href="home">Todas</a>
                    </div>
                </div>    
            {elseif $position == "categorias" or $position == "detalleItem"}
                <div class='container'>
                    <div class='row'>  
                        <div class='col'>              
                            <button type='button' class='btn btn-outline-danger'>
                            <a class='btn btn-outline-danger btn-lg active' href="home">Home</a></button>
                        </div>
                    </div>
                </div> 
            {elseif $position == "intoCategorias"} 
                <div class='container'>
                    <div class='row'>  
                        <div class='col'>              
                            <button type='button' class='btn btn-outline-danger'>
                            <a class='btn btn-outline-danger btn-lg active' href="home">Home</a></button>
                        </div>
                        <div class='col'>              
                            <button type='button' class='btn btn-outline-danger'>
                            <a class='btn btn-outline-danger btn-lg active' href="Categorias">Categorias</a></button>
                        </div>
                    </div>
                </div> 
            {elseif $position == "error"} 
                <div class='container'>
                    <div class='row'>  
                        <div class='col'>              
                            <button type='button' class='btn btn-outline-danger'>
                            <a class='btn btn-outline-danger btn-lg active' href="home">Home</a></button>
                        </div>
                        <div class='col'>              
                            <button type='button' class='btn btn-outline-danger'>
                            <a class='btn btn-outline-danger btn-lg active' href="{$update}{$id}">Back</a></button>
                        </div>
                    </div>
                </div>  
            <h1 class="error"> {$error} <h1>
            {/if}
            </div>
        </div> 