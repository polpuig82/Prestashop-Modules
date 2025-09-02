{if $pCurso}
    
    {foreach from=$pCurso->order item=producto}
        <script>
            nid={$producto['productId']};
            nquantity="{$producto['quantity']}";
            var nodo = {
                "id" : nid,    //your artist variable
                "quantity" : nquantity   //your title variable
            };
            arrayPedido{$contadorGeneral}.push(nodo);
        </script>

        {if $producto['productId']>0}
        <div class="orderEntregaenCurso boxItemEditor simple">
            <div class="lineasimple" >
                <div class="lineaproduct" style="display: inline-block; vertical-align: top;">
                    <div style="display: inline-block; vertical-align:top;">
                    <img class="imageprin" src="{$producto['image']}">
                    </div>
                    <div style="display: inline-block;">
                    <p class="headerEntregaenCurso">{$producto['name']}</p>
                    <p class="headerEntregaenCurso">Cantidad: {$producto['quantity']}</p>
                    <p class="headerEntregaenCurso">Precio: {$producto['grossUnitPrice']}&nbsp€</p>
                    
                    {if count($producto['content'])>0}
                    
                    {foreach from=$producto['content'] item=pro}
                    <li style="color:#ffffff; font-weight: 300;">{$pro['name']}</li>
                    
                    {/foreach}
                    {/if}    
                   </div>
                    </div>
                </div>
            </div>
       
        {/if}
        {/foreach}

{/if}