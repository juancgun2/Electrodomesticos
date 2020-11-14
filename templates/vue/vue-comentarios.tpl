{literal}

<div class="col-md-8" id="vueComentarios">
    <ul class="list-group">
        <li class="row" 
        v-for="comentario in comentarios"
        :idComentario="comentario.idComentario">
            <div class="col-md-8">
                <p>{{comentario.descripcion}}</p>
            </div>
            <div class="col-md-4"> 
                <p> {{comentario.puntuacion}}</p>
            </div>
        </li>
        <button v-if="vueComentarios.rol == admin"> Eliminar </button>
    </ul>
</div>

{/literal}