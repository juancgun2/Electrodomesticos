{literal} 
<div class="container d-flex" id="vueComentarios">   
    <div class="col-md-10">
        <h4> Comentarios </h4>
        <div class="scrollComent col-md-10 mb-4">
            <ul class="list-group list-coment" v-if="this.rol === 'admin'">
                <li class="row mt-1 ml-1 border rounded-top" 
                    v-for="comentario in comentarios"
                    :idComentario="comentario.idComentario">
                    <div class="descripcionComent col-md-10 px-2">
                        <small class="container d-flex">
                            <div v-for="p in estrellas(comentario.puntuacion)">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star-fill mr-1" fill="red" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                </svg>
                            </div>
                        </small>
                        <p class="ow-anywhere word-break ow-break-word" >{{comentario.descripcion}}</p>
                    </div>
                    <div class="col-md-2 d-flex align-baseline p-2">
                        <button class='btn btn-secondary' v-on:click="eliminar(comentario.idComentario)"> Eliminar </button>
                    </div>
                </li>
            </ul>
            <ul class="list-group list-coment" v-else>
                <li class="row mt-1 ml-1 border rounded-top" 
                    v-for="comentario in comentarios"
                    :idComentario="comentario.idComentario">
                    <div class="descripcionComent col-md-12 px-2">
                        <small class="container d-flex">
                            <div v-for="p in estrellas(comentario.puntuacion)">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star-fill mr-1" fill="red" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                </svg>
                            </div>
                        </small>
                        <p class="ow-anywhere word-break ow-break-word" >{{comentario.descripcion}}</p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="dontShow p-3 mb-2 bg-danger text-white" id="containerErrorComentario">
            <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-exclamation-diamond" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M6.95.435c.58-.58 1.52-.58 2.1 0l6.515 6.516c.58.58.58 1.519 0 2.098L9.05 15.565c-.58.58-1.519.58-2.098 0L.435 9.05a1.482 1.482 0 0 1 0-2.098L6.95.435zm1.4.7a.495.495 0 0 0-.7 0L1.134 7.65a.495.495 0 0 0 0 .7l6.516 6.516a.495.495 0 0 0 .7 0l6.516-6.516a.495.495 0 0 0 0-.7L8.35 1.134z"/>
            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
            </svg> <span id="errorComentario"> </span>
        </div> 
    </div>
    <aside class="col-md-2 justify-content-center border-left">
        <div class="row justify-content-center ml-1">
            <h5 class="align-content-center h4"> Promedio <span class="border border-danger myPromedio p-2"> {{promedioValoracion}} </span> </h5>
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

