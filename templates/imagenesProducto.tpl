
{if !empty($imagenes)}
<div class="container-fluid d-flex"
    <div class="containerImages">
        {foreach from=$imagenes item=imagen}
            <div class="imagenes">
                <img src="{$imagen->path}" alt="" class="img-fluid img-thumbnail">
                {if $sesion === "admin"}
                    <button class='btn dangerDelete' type='button'><a class=' btn btn-danger' href="eliminarImagen/{$imagen->id_imagen}">
                    Eliminar</a></button>
                {/if}
            </div>
        {/foreach}
    </div>
</div>
{/if}
