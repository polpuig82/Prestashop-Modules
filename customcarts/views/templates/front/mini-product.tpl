<script>
    var productosCestaDefinida = {$productosCestaDefinida|@json_encode nofilter};
    var productosCestaAlternativa = {$productosCestaAlternativa|@json_encode nofilter};
    var control = {$control };

</script>

</h3> {l s='Basket content' mod='customcarts'}</h3>
{assign var=count value=1}
{foreach from=$productosCestaDefinida item=prD}
<div class="boxItemEditor">
    <div class="editableItemFrame" id="precognis{$count}">
        <div class="image">
            <img src="{$prD.image}" />
        </div>
        {if $prD.intercambiable!=0}
        <a class="btn definido" style="padding:0px; color:#46735C; text-align: start;" onClick="desplegar({$count})">
            <div style="text-align:left !important;">
                <span style="color:#290000; font-size: 1.2rem">{$prD.name}</span>
                <br/>
                <span style="color:#290000;font-weight:400;">{$prD.cantidad} {$prD.unidad_medida} {if $prD.unidades_aprox}({$prD.unidades_aprox}){/if}</span>
                <br/>
                <img src="/img/cms/cambiar.png" style="width:20px;"><span style="color:#45725A; font-weight:400;">&nbsp{l s='CAMBIAR' mod='customcarts'}</span></a>
            </div>
        {/if}
        
        
        {if $prD.intercambiable==0}
        <div style="        ">
            <img src="/img/c/gift.png" 
            style="
            color: #2f4e3e !important;
            content: url('/img/c/gift.png');
            margin-right: 6px;
            width:18px;">
            {$prD.name}
            </div>
        
        {/if}

        <input type="hidden" id="ElementoCestaInp{$count}" name="ElementoCestaInp{$count}" value="{$prD.componente}">
    </div>
    
    <div class="row" id="main-mini-carrousel-box id{$count}"> 
        {include file="./mini-carrousel.tpl" productoDefinido=$prD productosCestaAlternativa=$productosCestaAlternativa}
    </div>
    {$count=$count+1}
</div>
{/foreach}