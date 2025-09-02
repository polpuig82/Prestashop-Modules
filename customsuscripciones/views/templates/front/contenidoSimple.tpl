{if $producto['productId']>0}
<div class="" id="precognis">
        <div class="editableItemFrame editableItemFrame_list">
            <div class="lineasimple">
            <div class="lineaproduct" style="display:flex; vertical-align: top;">
            <img height="70px" src="{$producto['image']} " >
            <div style="display:inline-block; vertical-align: top; margin-left: 30px;">
            <p>{$producto['name']}</p>
            <p>{l s='Cantidad: ' mod='customsuscripciones'} {$producto['quantity']}</p>
            {* <p>Precio: {$producto['grossUnitPrice']}€</p> *}
            </div>
            </div>
            </div>
        </div>

</div>

{/if}
