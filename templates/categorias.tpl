{include file="header.tpl"}
<div class="container"> 
    <h1> Categorias </h1>   
        <section class="container categorias">
            {foreach from=$categorias item=categoria}
                <div class="animacion"> 
                <a class="link" href="productos/{$categoria->name}">
                    <article class="textCategoria"> {$categoria->name} 
                        <div class="box">
                            <button class='btn' type='button'>
                                <a class='btn btn-warning'
                                href="formEditarCategoria/{$categoria->id}">Editar</a></button>
                            <button class='btn dangerDelete'
                                type='button'><a class='btn btn-danger'
                                href="eliminarCategoria/{$categoria->id}">Eliminar</a></button>
                        </div> 
                    </article>
                    </a>
                </div>
            {/foreach} 
        </section>
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