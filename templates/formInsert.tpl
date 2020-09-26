{include file="allItems.tpl"}
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
            <select name="nameCategoria" class="form-control">
                {foreach from=$productos item=producto}
                    <option>{$producto->name}</option>
                {/foreach}
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form> 
</div> 
{include file="footer.tpl"}