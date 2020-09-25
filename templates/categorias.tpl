{include file="header.tpl"}
<div class='container'> 
    <h1> Categorias </h1>   
            <table class='table table-sm table-hover'>
                <thead>
                    <tr>
                        <th scope='col'>Nombre</th>
                        <th scope='col'>Editar</th>
                        <th scope='col'>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$categorias item=categoria} 
                    <tr>
                        <th>{$categoria->name}</th>
                        <td><button class='btn' type='button'>
                            <a class='btn btn-warning'
                            href="formEditarCategoria/{$categoria->id}">Editar</a></button></td> 
                        <td ><button class='btn dangerDelete'
                            type='button'><a class='btn btn-danger'
                            href="eliminarCategoria/{$categoria->id}">Eliminar</a></button></td>
                    </tr>
                    {/foreach} 
                </tbody>
            </table>
        </div>
        <div class="container">
            <h1> Insertar Categoria </h1>
                <form action="insertCategoria" method="POST">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" name="nombreCategoria">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form> 
        </div>
        <script src="./js/dangerDelete.js"></script>
{include file="footer.tpl"}