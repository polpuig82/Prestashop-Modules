<div class="contentcesta" id="contentcesta {$producto['productId']}-{$contadorGeneral}-{$producto.lineId}">
    <span class="intlinea"> {l s='Contenido de la cesta:' mod='customcarts'}</span>
    {assign var=count value=1}
    {assign var=contadorLinea value=1}

    <script>

        var arrayCesta{$contadorGeneral}{$linea}=[];
        var cambiosCesta{$contadorGeneral}{$linea}=0;

    </script>
   
 {foreach from=$cesta['content'] item=prD}
    <div class="boxItemEditor2 listado">
        <!-- Agregamos atributos data- para identificar el producto -->
        <div class="editableItemFrame" 
             data-productid="{$prD['productId']}" 
             data-num="{$contadorGeneral}" 
             data-linea="{$linea}" 
             data-iddesh="precognis{$contadorGeneral}-{$contadorLinea}-{$linea}">
        
            <div class="lineaTitulCesta" id="precognis{$contadorGeneral}-{$contadorLinea}-{$linea}">
                <div class="image imgCesta">
                    <img src="{$prD['image']}" />
                </div>
                <script>
                    nid = {$prD['productId']};
                    nimage = "{$prD['image']}";
                    nname = "{$prD['name']}";
                    var nodo = {
                        "id": nid,
                        "image": nimage,
                        "name": nname
                    };
                    arrayCesta{$contadorGeneral}{$linea}.push(nodo);
                </script>
                
                <div style="width:300px !important;padding-left: 10px;">
                    <p class="titulCesta" style="color: #290000; font-size: 1.2rem;">
                        <b>{$prD['name']}</b>
                        {if isset($prD.origin) && $prD.origin}
                            <span style="color:#290000;font-weight:400;font-size: 1rem">({$prD.origin})</span>
                        {/if}
                    </p>
                    <p class="titulCesta">
                        {$prD['cantidad']} {$prD['UM']} {if isset($prD['aproxUnits'])}({$prD['aproxUnits']}){/if}
                    </p>
                    
                    {if $prD['changeAllowed']}
                        <!-- Agregamos data-idcambio y una clase común (por ejemplo, "cambiarBtn") -->
                        <a class="btn btn-terciary maxchanges{$contadorGeneral} cambiarBtn definido" 
                           id="definido" 
                           data-idcambio="{$prD['productId']}"
                           data-num="{$contadorGeneral}"
                           data-linea="{$linea}"
                           onclick="desplegarcarrouselProductoCesta('{$prD['productId']}-{$contadorGeneral}-{$linea}')" 
                           style="color: #46735C!important; display: flex;font-weight:400; padding: 0;">
                            <img src="/img/cms/cambiar.png" style="width:20px;">&nbsp;{l s='CAMBIAR' mod='customentregasencurso'}&nbsp;
                        </a>
                        {$count = $count + 1}
                    {/if}
                </div>
                
                {if $prD['changeAllowed'] === false}
                    <img src="/img/cms/gift.png" style="width:20px; margin-right: 18px;">
                {/if}
            </div>
            
            {if $prD['changeAllowed']}
                <div class="row" id="main-mini-carrousel-box id-{$prD['productId']}-{$contadorGeneral}-{$linea}">
                    {include file="module:customentregasencurso/views/templates/front/mini-carrouselProductoCesta.tpl" }
                </div>
            {/if}
        </div>
        
        {$count = $count + 1}
        {$contadorLinea = $contadorLinea + 1}
    </div>
{/foreach}

    {* Añadir a array general *}
    <script>
        general={$contadorGeneral};
        linea={$linea};
        lista=window["arrayCesta"+general+linea];
        nid={$producto['productId']};
        nquantity={$producto['quantity']};
        ngrossUnitPrice={$producto['grossUnitPrice']};
        {if $producto['orderPlanId']!=""}
        norderPlanId="{$producto['orderPlanId']}";
        {else}
        norderPlanId=null;
        {/if}
        var nodo = {
            "id" : nid,    //your artist variable
            "quantity" : nquantity,    //your artist variable
            "orderPlanId" : norderPlanId,    //your artist variable
            "grossUnitPrice" : ngrossUnitPrice,    //your artist variable
            "lista" : lista,   //your title variable
        };
        arrayPedido{$contadorGeneral}.push(nodo);
    </script>



    <script>
        var arrayAlternativo{$contadorGeneral}{$linea}=[];
    </script>
    {*Rellenar alternativos*}
    {foreach from= $cesta['alternativos'] item=prA}
        <script>
            nid={$prA['productId']};
            nimage="{$prA['image']}";
            nname="{$prA['name']}";
            var nodo = {
                "id" : nid,    //your artist variable
                "image" : nimage,   //your title variable
                "name" : nname   //your title variable
            };
            arrayAlternativo{$contadorGeneral}{$linea}.push(nodo);
        </script>
    {/foreach}
</div>