<div class="container-xl" style="text-align: center; margin-top: 20px; margin-bottom: 30px;">
    <input id="searchbar_{$contadorGeneral}" class="searchbar" style="margin-bottom: 4%" type="text" name="search" placeholder="Buscar productos" data-contador="{$contadorGeneral}">
    <div id="resultados_{$contadorGeneral}" class="resultados" data-id="{$contadorGeneral}" style="text-align: center;">
        {if isset($productosrecomendados) && $productosrecomendados != ''}
            {include file="module:customsuscripciones/views/templates/front/search/_partials/results.tpl" productosrecomendados=$productosrecomendados contadorGeneral=$contadorGeneral}
        {/if}
    </div>
</div>