<input type="hidden" value="{$sesion}" id="rol">
<section class="container d-flex">
    <div class="col-md-10">
        {include file="vue/vue-comentarios.tpl"}
        {include file="formComentarios.tpl"}
    </div>
    <aside class="col-md-2 justify-content-center border-left">
        <div class="row justify-content-center">
            <h5>Promedio</h5>
        </div>
        <div class="row justify-content-center">
            {for $start=1 to $promedio->puntuacion}
                <div>
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star-fill" fill="red" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                    </svg> 
                </div>
            {/for}
        </div>
    </aside>
</section>
<script src="./js/comentarios.js"></script>