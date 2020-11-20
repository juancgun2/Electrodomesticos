
{if !empty($imagenes)}
    <div class="containerImages">
        {foreach from=$imagenes item=imagen}
            <div class="imagenes">
                <img src="{$imagen->path}" alt="" class="img-thumbnail">
                {if $sesion === "admin"}
                    <button class='btn dangerDelete' type='button'><a class=' btn btn-danger' href="eliminarImagen/{$imagen->id_imagen}">
                    Eliminar</a></button>
                {/if}
            </div>
        {/foreach}
    </div>
{/if}
