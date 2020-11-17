{include file="header.tpl"}
<div class="container">
    <div class="row"> 
        <div class="col">
            <h1> Editar producto {$producto->nombre} </h1>   
        </div> 
    </div>    
        <form action="editar" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nombre</label>
                <input type="hidden" name="id_producto" value="{$id_producto}">
                <input type="text" class="form-control" value="{$producto->nombre}" 
                    name="nombre" placeholder="{$producto->nombre}">
            </div>
            <div class="form-group">
                <label> Descripcion </label>
                <input class="form-control" value="{$producto->descripcion}"
                    name="descripcion" type="text" placeholder="{$producto->descripcion}">
            </div>
            <div class="form-group">
                <label>Precio</label>
                <input placeholder='{$producto->precio}' value="{$producto->precio}"
                    name="precio" class="form-control" type="text">
            </div>
            <div class="form-group">
                <label>Stock</label>
                <input placeholder='{$producto->stock}' value="{$producto->stock}" 
                    type="text" class="form-control" name="stock">
            </div>
            <div class="form-group">
                <label>Categoria</label>
                <select name="nameCategoria" class="form-control">
                    {foreach from=$categorias item=categoria}
                        <option>{$categoria->name}</option> 
                    {/foreach}      
                </select>
            </div> 
            <div class="form-group">
                <label>Agregar imagen</label>
                <input type="file" class="form-control-file" name="imagen">
            </div>
            <div class="row"> 
                <div class="col">
                    <button type="submit" class="btn btn-primary">Submit</button>         
                    <button type="button" class="btn">
                    <a class="btn btn-danger" href=home>Cancelar</a></button>
                </div> 
            </div>    
        </form> 
</div>
{include file="footer.tpl"}