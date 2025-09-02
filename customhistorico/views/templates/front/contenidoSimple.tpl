{if $producto['productId']>0}
<div class="" id="precognis" style=" border-bottom: 1px solid rgba(23,115,67,0.5);">
        <div class=" editableItemFrame">
             <div class="lineasimple" > 
             
            <div class="lineaproduct" style="display:flex;">

            <div><img src="{$producto['image']}" /></div>

            <div style="
    margin-left: 10px;
"><p>{l s='Cantidad: ' mod='customsuscripciones'} {$producto['quantity']}</p>
            <p>{$producto['name']}</p>

            
{if $producto['content']}

<div class="dropdown"  style="margin-bottom:10px;">
  <a class="dropdown-toggle"  role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#2F4E3E;cursor:pointer">
    Contenido cesta
  </a>
<br>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    <div class="editableItemFrame">
          {foreach from=$producto['content'] item=prD}
          <ul>
          <div style="display:flex;">
          <img src="{$prD['image']}" width="50" height="50" />   
          <span style="margin-top:10%;font-size:11px;">&nbsp{$prD['name']}  ({$prD['cantidad']} {$prD['UM']})</span>
          </div>
          </ul>
            {/foreach}
          </div> 
  </div>
</div>
          
{/if} 
            <p>{$producto['grossUnitPrice']}&nbsp€</p></div></div>
            
            </div>
       
        </div>

</div>

{/if}


{* {if $producto['productId']>0}
<div class="" id="precognis" style=" border-bottom: 1px solid rgba(23,115,67,0.5);">
        <div class="entregaDiv editableItemFrame">
             <div class="lineasimple"> 
            <div class="lineaproduct">
            <p>{l s='Cantidad: ' mod='customsuscripciones'} {$producto['quantity']}</p>
            <p>{$producto['name']}</p>
            <p>{$producto['grossUnitPrice']}&nbsp€</p>
            
           
            </div></div>
        </div>

</div>

{/if} *}
