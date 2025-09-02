{* <div class="container-xl" style="text-align: center; margin-top: 20px; margin-bottom: 30px;">
    <input id="searchbar" type="text" name="search" placeholder="{l s='Buscar productos' mod='customentregasencurso'}" data-contador="{$contadorGeneral}">
    <div id="resultados" style="text-align: center;">
        {if isset($productosrecomendados) && $productosrecomendados != ''}
            {include file="module:customentregasencurso/views/templates/front/search/_partials/results.tpl" productosrecomendados=$productosrecomendados contadorGeneral=$contadorGeneral}
        {/if}
    </div>
</div> *}