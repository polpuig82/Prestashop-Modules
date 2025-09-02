{if $cesta['productId']>0}

    <div class="" id="precognis">
        <div class="editableItemFrame">
            <div class="image imgCesta">
                <img src="{$cesta['image']}" />
            </div>
            <div class="lineasimple" style="display:flex;">
                <div style="display:inline-block; margin-left: 80px;">

                        <div style="display:flex;">
                        <p class="lineaproduct">{$cesta['name']}</p>&nbsp&nbsp
                        
                        {if $cesta['id_category'] == '129'}



                            {else}  
        
                            {assign var="hasProduct2010" value=false}
        
                            {foreach from=$pCurso->order item=cesta}
                                {if $cesta.productId == 2010}
                                    {assign var="hasProduct2010" value=true}
                                    {break} {* Salir del bucle después de encontrar el primer producto con productId 2010 *}
                                {/if}
                            {/foreach}
        
                            {if $hasProduct2010}
                                {foreach from=$pCurso->order item=productoCash}
                                    {if $producto.productId == 2010 && !$firstButtonShown}
                                        <a onClick="removeItemFromOrder('{$producto.productId}','{$pCurso->obId}','{$contadorGeneral}','{$linea}')">
                                            <span style="display: inline;font-family: Lora; color: #177343; font-size: 12px; font-weight: 300; cursor:pointer;">
                                                <i class="fa fa-trash" aria-hidden="true" style="color: #177343; font-weight: 300; "></i>&nbsp;&nbsp;&nbsp;
                                                {* {l s='Eliminar de la próxima entrega' mod='customentregasencurso'} *}
                                            </span>
                                        </a>
                                        {assign var="firstButtonShown" value=true}
                                    {/if}
                                {/foreach}
                            {else}
                                <a onClick="removeItemFromOrder('{$producto.productId}','{$pCurso->obId}','{$contadorGeneral}','{$linea}')">
                                            <span style="display: inline;font-family: Lora; color: #177343; font-size: 12px; font-weight: 300; cursor:pointer;">
                                                <i class="fa fa-trash" aria-hidden="true" style="color: #177343; font-weight: 300; "></i>&nbsp;&nbsp;&nbsp;
                                                {* {l s='Eliminar de la próxima entrega' mod='customentregasencurso'} *}
                                            </span>
                                        </a>
                            {/if}
        
                            {/if}
                        </div>

                    {* <p class="lineaproduct">{$cesta['name']}</p> *}
                    <p class="lineaproduct">{l s='Cantidad:' mod='customentregasencurso'} {$cesta['quantity']}</p>
                    <p class="lineaproduct">{l s='Precio:' mod='customentregasencurso'}
                        <span class="precio-lineaproduct" data-id-product="{$cesta.productId}">{$cesta['grossUnitPrice']|number_format:2:',':'.'}</span>&nbsp€</p>

                    
                                    {*{/if} *}

                                    {* {include file="module:iqitwishlist/views/templates/front/categoria_virtual/categoria_virtual.tpl"} *}


                                </div>



                            </div>
                        </div>

                    </div>
<script>
    general={$contadorGeneral};
    nid={$cesta['productId']};
    nqty={$cesta['quantity']};
    ngrossUnitPrice={$cesta['grossUnitPrice']};
    {if $cesta['orderPlanId']!=""}
        norderPlanId="{$cesta['orderPlanId']}";
    {else}
        norderPlanId = null;
    {/if}
    var nodo = {
        "id": nid, //your artist variable
        "quantity": nqty, //your artist variable
        "grossUnitPrice": ngrossUnitPrice,
        "orderPlanId": norderPlanId, //your artist variable
    };
    arrayPedido{$contadorGeneral}.push(nodo);
</script>
{/if}