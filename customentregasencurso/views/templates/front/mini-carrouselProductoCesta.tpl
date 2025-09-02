<div class="container-xl">
    <div class="col-md-12" id="mycarouselProductoCesta {$prD['productId']}-{$contadorGeneral}-{$linea}">
               <p onclick="desplegarcarrouselProductoCesta('{$prD['productId']}-{$contadorGeneral}-{$contadorLinea}')" style="text-align: end;
    color: #46735C;
    font-weight: 400;
    padding-top: 5px;
    cursor: pointer;
    background-color:#ffffff;
    margin-bottom:-1px;
    padding-right: 10px;" 
    class="button-close-carrousel">CERRAR ✖</p>
<div class="owl-carousel owl-theme basic">

            {$id_product_attribute_producto_contenido = Combination::getIdProductAttributeByIdAttribute($prD['productId'], $cesta['frecuencyId'])}
            {$specific_price_producto_contenido = SpecificPrice::getSpecificPrice($prD['productId'], $shop["id"], $currency["id"], $pCurso->shippingAddress->id_country, $customer["id_default_group"], 1, $id_product_attribute_producto_contenido)}
            {$precio_producto_contenido = Product::getPriceStatic($prD['productId'], true, $id_product_attribute_producto_contenido, 6, null, false, true, 1, false, null, null, null, $specific_price_producto_contenido)}

            {assign var=key value=0}
            {foreach from= $cesta['alternativos'] item=prA}

            <div class="item">
            
              <div class="carousel-element" style="margin-top: 20px;padding-bottom: 8rem;">
    {$id_product_attribute_producto_alternativo = Combination::getIdProductAttributeByIdAttribute($prA['productId'],$cesta['frecuencyId'])}
    {$specific_price_producto_alternativo = SpecificPrice::getSpecificPrice($prA['productId'], $shop["id"], $currency["id"], $pCurso->shippingAddress->id_country, $customer["id_default_group"], 1, $id_product_attribute_producto_alternativo)}
    {$precio_unitario_alternativo = Product::getPriceStatic($prA['productId'], true, $id_product_attribute_producto_alternativo, 6, null, false, true, 1, false, null, null, null, $specific_price_producto_alternativo)}

    {* Comprobamos si es el mismo producto *}
    {assign var=esMismoProducto value=($prA['productId'] == $prD['productId'])}

    {* Si es el mismo producto, el impacto debe ser 0 *}
    {if $esMismoProducto}
        {assign var=precio_producto_alternativo value=0}
    {else}
        {assign var=precio_producto_alternativo value=($incremento_contenido_alternativo * $precio_unitario_alternativo|floatval * $prA['cantidad']) - ($precio_producto_contenido|floatval * $prD['cantidad'])}
    {/if}

    {* Condición para ocultar el precio si la diferencia es mínima o son el mismo producto *}
    {assign var=ocultarPrecio value=($precio_producto_alternativo|floatval <= 0.04 && $precio_producto_alternativo|floatval >= -0.04) || $esMismoProducto}

    {if $ocultarPrecio}
        {$precio_producto_alternativo = 0}
    {/if}

    <img onclick="changeItemFromBasket({$key},{$prD['productId']},{$contadorGeneral},{$contadorLinea},{$producto['productId']},{$linea},{$cesta['lineId']},'{$pCurso->obId}',{$precio_producto_alternativo|floatval|number_format:2})" src="{$prA['image']}" />
    
    <h4 
        style="color: #46735C !important;" 
        onclick="changeItemFromBasket({$key},{$prD['productId']},{$contadorGeneral},{$contadorLinea},{$producto['productId']},{$linea},{$cesta['lineId']},'{$pCurso->obId}',{$precio_producto_alternativo|floatval|number_format:2})"> 

        {if $precio_producto_alternativo|floatval > 0.04}
            +
        {/if}

        {if $ocultarPrecio}
            <span class="precioOculto">{$precio_producto_alternativo|floatval|number_format:2}&nbsp€</span><br>
        {else}
            {$precio_producto_alternativo|floatval|number_format:2}&nbsp€<br>
        {/if}

        <p style="margin-bottom: 0;font-weight: 400!important; color: #66504a!important;">{$prA['cantidad']} {$prA['UM']}</p>

        {if isset($prA['aproxUnits'])}
            <p style="margin-bottom: 0;font-weight: 400!important; color: #66504a!important;">({$prA['aproxUnits']})</p>
        {else}
            <p style="margin-top: 16px;font-weight: 400!important; color: #66504a!important;"></p>
        {/if}

        <p style="color: #46735C !important;font-weight: 400!important;margin-bottom:0;">{$prA['name']}</p>
        <span style="font-weight:400;color: #66504a!important;font-size: 10pt;">{if $prA.origin} ({$prA.origin}){/if}</span>
    </h4>
</div>


            </div>
            {$key=$key+1}
            {/foreach}
            
        </div>
    </div>
</div>