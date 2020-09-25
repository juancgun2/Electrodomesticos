{include file="header.tpl"}

<table class='table table-hover table-dark'>
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
    <tbody>
    {foreach from=$productos item=producto} 
        <tr>
            <th scope='col'>{$producto->nombre}</th>
            <td>{$producto->precio}</td>
            <td>{$producto->stock}</td> 
            <td>{$producto->name}</td> 
            <td><button class='btn btn-secondary' type='button'><a class='btn btn-secondary btn-lg active'
                href="verDetalle/{$producto->id}">Detalle</a></button></td> 
                <td><button class='btn btn-secondary' type='button'><a class='btn btn-warning btn-lg active'
                href="formEditar/{$producto->id}">Editar</a></button></td> 
            <td><button class='btn btn-secondary' type='button'><a class='btn btn-outline-danger btn-lg active'
            href="eliminarProducto/{$producto->id}">Eliminar</a></button></td>
        </tr>
    {/foreach}
    </tbody>    
</table> 
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
                {foreach from=$categorias item=categoria}
                    <option>{$categoria->name}</option>
                {/foreach}
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form> 
</div> 
{include file="footer.tpl"}