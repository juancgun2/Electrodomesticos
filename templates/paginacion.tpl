<div class="container-fluid d-flex justify-content-center border-top border-bottom mb-4 bg-light">
    <div class="mobile d-inline-flex align-self-center pl-4 pb-0 mr-3">
        <div class="d-flex">
            <p class="mt-1">Mostrar:</p>
            <a class="btn border rounded ml-1 font-weight-bold bg-info text-white" href="home?cantidad={4}"> 4  </a>
            <a class="btn border rounded ml-1 font-weight-bold bg-info text-white" href="home?cantidad={8}"> 8  </a>
            <a class="btn border rounded ml-1 font-weight-bold bg-info text-white" href="home?cantidad={12}"> 12 </a>
        </div>
    </div>
    <div class="pl-5 pr-5 ml-2 mr-2"></div>
    <div class="d-inline-flex align-self-center">
        <div class="d-flex">
            {if $pagina > 1} 
                <button class='btn' type='button'><a class='btn' 
                    href="home?page={$pagina-1}{if isset($smarty.get.cantidad)}&cantidad={$smarty.get.cantidad}{else}&cantidad=4{/if}">
                <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-arrow-left-square bg-white" fill="black" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                </svg>
            </a></button>
            {/if}   
            <span class="text-white border rounded-circle bg-info align-self-center p-2 pl-3 pr-3 font-weight-bold">{$pagina}</span>
            {if $nextPage === true}
                <button class='btn' type='button'><a class='btn' 
                    href="home?page={$pagina+1}{if isset($smarty.get.cantidad)}&cantidad={$smarty.get.cantidad}{else}&cantidad=4{/if}">
                    <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-arrow-right-square bg-white" fill="black" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                        <path fill-rule="evenodd" d="M4 8a.5.5 0 0 0 .5.5h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5A.5.5 0 0 0 4 8z"/>
                    </svg>
                </a></button>
            {/if}
        </div>
    </div>
</div>