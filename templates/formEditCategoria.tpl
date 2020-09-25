{include file="header.tpl"}
<div class="container">
    <div class="row"> 
        <div class="col">
            <h1> Editar categoria {$categoria->name} </h1>   
        </div> 
    </div>    
        <form action="editarCategoria" method="POST">
            <div class="form-group">
                <label>Nombre</label>
                <input type="hidden" name="id_categoria" value="{$categoria->id}">
                <input type="text" class="form-control" value="{$categoria->name}" 
                    name="nombreCategoria" placeholder="{$categoria->name}">
            </div> 
            <div class="row"> 
                <div class="col">
                    <button type="submit" class="btn btn-primary">Submit</button>         
                    <button type="button" class="btn">
                    <a class="btn btn-danger" href=Categorias>Cancelar</a></button>
                </div> 
            </div>    
        </form> 
</div>
{include file="footer.tpl"}