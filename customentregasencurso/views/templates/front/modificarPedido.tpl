{if $pCurso} <div class="">
    <p>{l s='Contenido :' mod='customentregasencurso'}</p>
</div>
<div id="contenido-pedido-encurso-{$pCurso->obId}"> {assign var="linea" value=1} {foreach from=$pCurso->order item=producto} {if $producto['productId']>0} <div class="orderEntregaenCurso {if $producto['content']|count > 0}contenido-pedido-ajax-cesta-{$pCurso->obId}{/if}" id="lineaPedido{$contadorGeneral}{$linea}">
        <div class="orderEntregaenCurso boxItemEditor2 simple">
            <div class="editableItemFrame"> {if $producto['content']} <div class="pedidolinea">
                    <div class="imageprin image imgCesta" style="margin-right:10px;">
                        <img class="imageprin" src="{$producto['image']}" />
                    </div>
                    <div style="display:inline-block;margin-left: 80px;">
                    <div style="display:flex;">
                    <p class="lineaproduct">{$producto['name']}</p>&nbsp&nbsp&nbsp
                    {assign var="hasProduct2010" value=false} {foreach from=$pCurso->order item=cesta} {if $cesta.productId == 2010} {assign var="hasProduct2010" value=true} {break} {/if} {/foreach} 
                    {if $hasProduct2010} 
                        {else}
                        <span data-toggle="modal" data-target="#exampleModal-{$pCurso->obId}" style="font-family: Lora; color: #177343; font-size: 12px; font-weight: 300;">
                         <i class="fa fa-trash" aria-hidden="true" style="color: #177343; font-weight: 300;cursor:pointer; "></i>
                    </span>
                        {/if}
                    </div>
                        <p class="lineaproduct">Cantidad: {$producto['quantity']}</p>
                        <p class="lineaproduct">Precio: <span class="precio-lineaproduct cesta" data-id-product="{$producto.productId}">{$producto['grossUnitPrice']|number_format:2:',':'.'}</span>€</p>
                        <div id="infoCambios_{$pCurso->obId}_{$producto.lineId}" data-num="{$contadorGeneral}" style="display: none; color:#9F3C30;padding-top:5px;font-weight:700"></div>
                        <div style="text-align: left; cursor: pointer;">
                            <div class="modal fade" id="exampleModal-{$pCurso->obId}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{l s='¿Seguro que quieres eliminar tu próxima cesta?' mod='customentregasencurso'}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body"> {l s='Recuerda que estás modificando tu próxima entrega y no tu suscripción' mod='customentregasencurso'} </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                            <button type="button" data-dismiss="modal" onClick="removeItemFromOrder('{$producto.productId}','{$pCurso->obId}','{$contadorGeneral}','{$linea}')" class="btn btn-primary">Sí</button>
                                        </div>
                                    </div>
                                </div>
                            </div> {assign var="hasProduct2010" value=false} {foreach from=$pCurso->order item=cesta} {if $cesta.productId == 2010} {assign var="hasProduct2010" value=true} {break} {* Salir del bucle después de encontrar el primer producto con productId 2010 *} 
                            {/if} 
                            {/foreach} 
                            {if $hasProduct2010} 
                            {foreach from=$pCurso->order item=productoCash} {if $producto.productId == 2010 && !$firstButtonShown} 
                            <p data-toggle="modal" data-target="#exampleModal" style="display: inline;font-family: Lora; color: #177343; font-size: 12px; font-weight: 300;">
                                {* <i class="fa fa-trash" aria-hidden="true" style="color: #177343; font-weight: 300; "></i>&nbsp&nbsp&nbsp {l s='Eliminar Cesta de la próxima entrega' mod='customentregasencurso'} *}
                            </p>
                        </div>
                        <a class="btn btn-primary button-aplicar-hover" style="width:100%; font-weight: 600; margin-top:20px;" onClick="desplegarContenidoCesta('{$producto['productId']}-{$contadorGeneral}-{$producto.lineId}')">
                            <i class="material-icons shopping-cart"></i> {l s='Edit Content' mod='customentregasencurso'} </a> {assign var="firstButtonShown" value=true} {/if} {/foreach}
                    </div> {else} <p data-toggle="modal" data-target="#exampleModal" style="display: inline;font-family: Lora; color: #177343; font-size: 12px; font-weight: 300;">
                         {* <i class="fa fa-trash" aria-hidden="true" style="color: #177343; font-weight: 300; "></i>&nbsp&nbsp&nbsp {l s='Eliminar Cesta de la próxima entrega' mod='customentregasencurso'}  *}
                    </p>
                </div>
                <a class="btn btn-primary button-aplicar-hover" style="width:100%; font-weight: 600; margin-top:20px;" onClick="desplegarContenidoCesta('{$producto['productId']}-{$contadorGeneral}-{$producto.lineId}')">
                    <i class="material-icons shopping-cart"></i> {l s='Edit Content' mod='customentregasencurso'} </a> {/if} {* <a onClick="removeItemFromOrder('{$producto.productId}','{$pCurso->obId}','{$contadorGeneral}','{$linea}')"> *}
            </div>
        </div> {include file="module:customentregasencurso/views/templates/front/contenidoCesta.tpl" cesta=$producto} {else} {include file="module:customentregasencurso/views/templates/front/contenidoSimple.tpl" cesta=$producto} {/if}
        <hr>
    </div>
</div>
</div> {/if} {assign var="linea" value=$linea+1} {/foreach} </div>
<div class="extra" id="extra{$contadorGeneral}">
</div>
<div class="row carrucontent" id="main-mini-carrousel-box id" style="padding: 0px 10px; background-color: transparent;">
    <div class=carruselfondo> {*<div class="carrutitle"> {l s='Completa Tu Cesta' mod='customentregasencurso'}</div>
        <div class="carrusubtitle"> {l s='Añade Productos a Tu pedido' mod='customentregasencurso'} </div>*} <div class="carrutitle"> {if $id_lang==1} {$tituloCarrousel1_ES} {else} {$tituloCarrousel1_CA} {/if} {* <p>{$id_lang}</p> *} </div>
        <div class="carrusubtitle"> {if $id_lang==1} {$descCarrousel1_ES} {else} {$descCarrousel1_CA} {/if} </div> {include file="module:customentregasencurso/views/templates/front/mini-carrouselAddPedido.tpl" productosrecomendados=$productosrecomendados1[$pCurso->obId]} <div style="background-color: #ffffff; padding: 12px;">
            <a class="btn btn-primary button-aplicar-hover-anadir" style="width: 50%;font-weight: 600;margin-top: 10px;margin-left: auto;margin-right: auto;display: block;background: rgba(0, 0, 0, 0);color: : #9f3c30;border: solid 1px #9f3c30!important;" href="{if $id_lang==1}{$categoryCarrousel1_ES}{else}{$categoryCarrousel1_CA}{/if}"> {if $id_lang==1} Ver más {$tituloCarrousel1_ES} {else} Veure més {$tituloCarrousel1_CA} {/if}</a>
        </div>
        <div class="carrutitle"> {if $id_lang==1} {$tituloCarrousel2_ES} {else} {$tituloCarrousel2_CA} {/if} </div>
        <div class="carrusubtitle"> {if $id_lang==1} {$descCarrousel2_ES} {else} {$descCarrousel2_CA} {/if} </div> {include file="module:customentregasencurso/views/templates/front/mini-carrouselAddPedido.tpl" productosrecomendados=$productosrecomendados2[$pCurso->obId]} <div style="background-color: #ffffff; padding: 12px;">
            <a class="btn btn-primary button-aplicar-hover-anadir" style="width: 50%;font-weight: 600;margin-top: 10px;margin-left: auto;margin-right: auto;display: block;background: rgba(0, 0, 0, 0);color: : #9f3c30;border: solid 1px #9f3c30!important;" href="{if $id_lang==1}{$categoryCarrousel2_ES}{else}{$categoryCarrousel2_CA}{/if}"> {if $id_lang==1} Ver más {$tituloCarrousel2_ES} {else} Veure més {$tituloCarrousel2_CA} {/if}</a>
        </div>
        <div class="carrutitle"> {if $id_lang==1} {$tituloCarrousel3_ES} {else} {$tituloCarrousel3_CA} {/if} </div>
        <div class="carrusubtitle"> {if $id_lang==1} {$descCarrousel3_ES} {else} {$descCarrousel3_CA} {/if} </div> {include file="module:customentregasencurso/views/templates/front/mini-carrouselAddPedido.tpl" productosrecomendados=$productosrecomendados3[$pCurso->obId]} <div style="background-color: #ffffff; padding: 12px;">
            <a class="btn btn-primary button-aplicar-hover-anadir" style="width: 50%;font-weight: 600;margin-top: 10px;margin-left: auto;margin-right: auto;display: block;background: rgba(0, 0, 0, 0);color: : #9f3c30;border: solid 1px #9f3c30!important;" href="{if $id_lang==1}{$categoryCarrousel3_ES}{else}{$categoryCarrousel3_CA}{/if}"> {if $id_lang==1} Ver más {$tituloCarrousel3_ES} {else} Veure més {$tituloCarrousel3_CA} {/if}</a>
        </div>
        <div class="carrutitle"> {if $id_lang==1} {$tituloCarrousel5_ES} {else} {$tituloCarrousel5_CA} {/if} </div>
        <div class="carrusubtitle"> {if $id_lang==1} {$descCarrousel5_ES} {else} {$descCarrousel5_CA} {/if} </div> {include file="module:customentregasencurso/views/templates/front/mini-carrouselAddPedido.tpl" productosrecomendados=$productosrecomendados5[$pCurso->obId]} <div style="background-color: #ffffff; padding: 12px;">
            <a class="btn btn-primary button-aplicar-hover-anadir" style="width: 50%;font-weight: 600;margin-top: 10px;margin-left: auto;margin-right: auto;display: block;background: rgba(0, 0, 0, 0);color: : #9f3c30;border: solid 1px #9f3c30!important;" href="{if $id_lang==1}{$categoryCarrousel5_ES}{else}{$categoryCarrousel5_CA}{/if}"> {if $id_lang==1} Ver más {$tituloCarrousel5_ES} {else} Veure més {$tituloCarrousel5_CA} {/if}</a>
        </div>
        <div class="carrutitle"> {if $id_lang==1} {$tituloCarrousel6_ES} {else} {$tituloCarrousel6_CA} {/if} </div>
        <div class="carrusubtitle"> {if $id_lang==1} {$descCarrousel6_ES} {else} {$descCarrousel6_CA} {/if} </div> {include file="module:customentregasencurso/views/templates/front/mini-carrouselAddPedido.tpl" productosrecomendados=$productosrecomendados6[$pCurso->obId]} <div style="background-color: #ffffff; padding: 12px;">
            <a class="btn btn-primary button-aplicar-hover-anadir" style="width: 50%;font-weight: 600;margin-top: 10px;margin-left: auto;margin-right: auto;display: block;background: rgba(0, 0, 0, 0);color: : #9f3c30;border: solid 1px #9f3c30!important;" href="{if $id_lang==1}{$categoryCarrousel6_ES}{else}{$categoryCarrousel6_CA}{/if}"> {if $id_lang==1} Ver más {$tituloCarrousel6_ES} {else} Veure més {$tituloCarrousel6_CA} {/if}</a>
        </div>
        <div class="carrutitle"> {if $id_lang==1} {$tituloCarrousel7_ES} {else} {$tituloCarrousel7_CA} {/if} </div>
        <div class="carrusubtitle"> {if $id_lang==1} {$descCarrousel7_ES} {else} {$descCarrousel7_CA} {/if} </div> {include file="module:customentregasencurso/views/templates/front/mini-carrouselAddPedido.tpl" productosrecomendados=$productosrecomendados7[$pCurso->obId]} <div style="background-color: #ffffff; padding: 12px;">
            <a class="btn btn-primary button-aplicar-hover-anadir" style="width: 50%;font-weight: 600;margin-top: 10px;margin-left: auto;margin-right: auto;display: block;background: rgba(0, 0, 0, 0);color: : #9f3c30;border: solid 1px #9f3c30!important;" href="{if $id_lang==1}{$categoryCarrousel7_ES}{else}{$categoryCarrousel7_CA}{/if}"> {if $id_lang==1} Ver más {$tituloCarrousel7_ES} {else} Veure més {$tituloCarrousel7_CA} {/if}</a>
        </div> 
        
        {*<div>
            <div class="carrutitle"> {if $id_lang==1} {$tituloCarrousel4_ES} {else} {$tituloCarrousel4_CA} {/if} </div>
            <div class="carrusubtitle"> {if $id_lang==1} {$descCarrousel4_ES} {else} {$descCarrousel4_CA} {/if} </div> include file="module:customentregasencurso/views/templates/front/search-carrouselAddPedido.tpl" productosrecomendados=$productosrecomendados4 {include file="module:customentregasencurso/views/templates/front/search/search-products.tpl" contadorGeneral=$contadorGeneral productosrecomendados=$productosrecomendados4}
        </div>
    </div>
</div>
<a class="btn btn-primary trigger_popup_fricc" onclick="enviarCambios({$contadorGeneral})">Aplicar Cambios</a>
<a class="btn btn-primary" onclick="enviarCambios({$contadorGeneral})">Aplicar Cambios</a> *} 

{/if} 

{literal} <style>
    .input-with-control {
        display: none;
    }
</style> {/literal}