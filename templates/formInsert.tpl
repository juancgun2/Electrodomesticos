{include file="allItems.tpl"}
{if $sesion==="admin"}
<div class="border-top configBorder"></div>
    <div class="container border border-bottom-0 border-top-0 mb-2">
        <h1> Insertar Producto </h1>
            <form action="insertProducto" method="POST" enctype="multipart/form-data">
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
                <select name="nameCategoria" class="form-control">
                    {foreach from=$categorias item=categoria}
                        <option>{$categoria->name}</option>
                    {/foreach}
                </select>
            </div>
             <div class="form-group">
                <label>Imagen</label>
                <input type="file" multiple class="form-control-file" name="imagen[]">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            </form> 
    </div> 
{include file="copyRight.tpl"}
{include file="footer.tpl"}
{else}
    {include file="copyRight.tpl"}
    {include file="footer.tpl"}
{/if}