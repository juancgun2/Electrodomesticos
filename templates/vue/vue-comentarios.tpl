{literal} 
<div class="container d-flex" id="vueComentarios">   
    <div class="col-md-10">
        <h4> Comentarios </h4>
        <div class="col-md-10 mb-4">
            <ul class="list-group" v-if="this.rol === 'admin'">
                <li class="row mt-1 ml-1 border rounded-top" 
                    v-for="comentario in comentarios"
                    :idComentario="comentario.idComentario">
                    <div class="col-md-10 px-2">
                        <small class="container d-flex">
                            <div v-for="p in estrellas(comentario.puntuacion)">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star-fill mr-1" fill="red" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                </svg>
                            </div>
                        </small>
                        <p>{{comentario.descripcion}}</p>
                    </div>
                    <div class="col-md-2 d-flex align-baseline p-2">
                        <button class='btn btn-secondary' v-on:click="eliminar(comentario.idComentario)"> Eliminar </button>
                    </div>
                </li>
            </ul>
            <ul class="list-group" v-else>
                <li class="row mt-1 ml-1 border rounded-top" 
                    v-for="comentario in comentarios"
                    :idComentario="comentario.idComentario">
                    <div class="col-md-12 px-2">
                        <small class="container d-flex">
                            <div v-for="p in estrellas(comentario.puntuacion)">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star-fill mr-1" fill="red" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                </svg>
                            </div>
                        </small>
                        <p>{{comentario.descripcion}}</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <aside class="col-md-2 justify-content-center border-left">
        <div class="row justify-content-center ml-1">
            <h5 class="align-content-center h4"> Promedio <span class="border border-danger p-2"> {{promedioValoracion}} </span> </h5>
        </div>
        <div class="row justify-content-center">
            <div v-for="e in estrellas(promedioValoracion)">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star-fill mr-1" fill="red" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                </svg> 
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <ul>
                <li class="row mt-2 ml-1" v-for="e in cantidadPorEstrellas">
                    {{e.estrellas}} estrellas -----> {{e.cantidad}}
                </li> 
            </ul>
        </div>
    </aside>
</div>
{/literal}

