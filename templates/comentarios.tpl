<input type="hidden" value="{$sesion}" id="rol">
<div class="border-top configBorder">
</div>
<section class="container">
    
        {include file="vue/vue-comentarios.tpl"}
        {if $sesion === 'admin' || $sesion === 'user'}
            {include file="formComentarios.tpl"}
        {/if}
    
</section>
<script src="./js/comentarios.js"></script>