{include file="header.tpl"}
<div class="table-responsive">
    <table class='table table-hover'>
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
            <tbody>
                <tr>
                    <th id="idProducto" scope='row'>{$detalle->id}</th>
                    <td>{$detalle->nombre|capitalize}</td>
                    <td>{$detalle->descripcion}</td> 
                    <td>{$detalle->precio}</td> 
                    <td>{$detalle->stock}</td> 
                    <td>{$detalle->name|capitalize}</td>  
                </tr>
            </tbody>    
    </table> 
</div>
{include file="imagenesProducto.tpl"}
{include file="comentarios.tpl"}
{include file="footer.tpl"} 