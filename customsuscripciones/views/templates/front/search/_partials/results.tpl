<div class="container-xl">
    <div class="col-md-12" id="searchcarrousel">
        <div class="owl-carousel owl-theme basic">
            {assign var=count value=1}
            {foreach from=$productosrecomendados item=prA}
                <div class="item">       
                    <div class="carousel-element"  id="search-$prA['productId']" style="margin-bottom: 100px!important;">
                        <img onclick="addItem('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}' , '{Context::getContext()->country->id}')"
                            src="{$prA.image}" />
                        <h4 onclick="addItem('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}')" name="{$prA.name} , '{Context::getContext()->country->id}'">
                            {$prA.name}</h4><h3 style="color: #290000;">€{$prA.grossUnitPrice}</h3>
                        <div class="input-with-control">
                            <span class="input-number-decrement" onclick="decrement">–</span>
                                <input name="qty{$prA.productId}{$count}" id="qty{$prA.productId}{$count}" class="input-number" type="text" value="1" min="1" max="10" style="width:45px;">
                            <span class="input-number-increment" onclick="increment">+</span>
                        </div>
                        <a onclick="addItem('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}', '{Context::getContext()->country->id}')"
                            class="btn btn-product-list" style="font-size:12px; padding: 5px; margin-top: 5px; margin-bottom: 5px;">{l s='AÑADIR'
                            mod='customcarts'}</a>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
</div>