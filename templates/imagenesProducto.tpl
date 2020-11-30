
{if !empty($imagenes)}
<div class="d-flex justify-content-center border-top bg-light">
    <h3> IMAGENES </h3>
</div>
<div class="container-fluid d-flex pb-3 pt-3 bg-light">
        {foreach from=$imagenes item=imagen}
            <div class="imagenes">
                <img src="{$imagen->path}" alt="" class="grande img-fluid img-thumbnail">
                {if $sesion === "admin"}
                    <button class='btn dangerDelete' type='button'><a class=' btn btn-danger' href="eliminarImagen/{$imagen->id_imagen}">
                    Eliminar</a></button>
                {/if}
            </div>
        {/foreach}
</div>
{/if}
