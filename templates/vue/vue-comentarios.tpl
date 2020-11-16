{literal}    
<div class="col-md-8" id="vueComentarios">
    <ul class="list-group" v-if="this.rol === 'admin'">
        <li class="row" 
        v-for="comentario in comentarios"
        :idComentario="comentario.idComentario">
            <div class="col-md-8">
                <p>{{comentario.descripcion}}</p>
            </div>
            <div class="col-md-2"> 
                <p> {{comentario.puntuacion}}</p>
            </div>
            <div class="col-md-2">
                <button v-on:click="eliminar(comentario.idComentario)"> Eliminar </button>
            </div>
        </li>
    </ul>
    <ul class="list-group" v-else-if="this.rol === 'user'">
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
    </ul>
</div>
{/literal}

