<div class="container-xl">
    <div class="col-md-12" id="mycarousel">
        <div class="owl-carousel owl-theme basic">
            {assign var=count value=1}
            {foreach from=$productosrecomendados item=prA}

            <div class="item">
                <div class="carousel-element" style="margin-bottom: 100px;">
                    <img onclick="addItem('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}','{$sCliente->shippingAddress->id_country}')" src="{$prA.image}" />
                    {* <h4 onclick="addItem('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}','{$sCliente->shippingAddress->id_country}')"> {$prA.name}</h4> *}

                    {* {if $prA.name|count_characters:true > 1 && $prA.name|count_characters:true <= 15} *}
                    {* <h4 onclick="addItem('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}','{$sCliente->shippingAddress->id_country}')" class="NombreMuyCorto"> *}
                        {* {$prA.name}{*{$prA.name|count_characters}*}</h4>
                    {* {/if} *}
                    {* {if $prA.name|count_characters:true >= 16 && $prA.name|count_characters:true <= 20} *}
                    {* <h4 onclick="addItem('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}','{$sCliente->shippingAddress->id_country}')" class="NombreCorto"> *}
                        {* {$prA.name}{*{$prA.name|count_characters}*}</h4> 
                    {* {/if} *}

                    {* {if $prA.name|count_characters:true >= 21 && $prA.name|count_characters:true <=25} *}
                    {* <h4 onclick="addItem('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}','{$sCliente->shippingAddress->id_country}')" class="NombreMedio"> *}
                        {* {$prA.name}{*{$prA.name|count_characters}*}</h4> 
                    {* {/if} *}

                    {* {if $prA.name|count_characters:true >= 26 && $prA.name|count_characters:true <=29} *}
                    {* <h4 onclick="addItem('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}','{$sCliente->shippingAddress->id_country}')" class="NombreLargo"> *}
                        {* {$prA.name}{*{$prA.name|count_characters}*}</h4> 
                    {* {/if} *}
                    {* {if $prA.name|count_characters:true >= 30} *}
                    {* <h4 onclick="addItem('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}','{$sCliente->shippingAddress->id_country}')" class="NombreMuyLargo"> *}
                        {* {substr($prA.name,0,9)}{$prA.name|count_characters}</h4> *}
                    {* {/if} *}
                    
                    {* COPIADO DE CUSTOMENTREGASENCURSO *}
                      
                    {if $prA.name|count_characters:true > 1 && $prA.name|count_characters:true <= 10}
                    <h4 onclick="addItem('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}','{$sCliente->shippingAddress->id_country}')" class="NombreMuyCorto">
                        {$prA.name}{*{$prA.name|count_characters}*}</h4>
                    {/if}
                    {if $prA.name|count_characters:true >= 11 && $prA.name|count_characters:true <= 25}
                    <h4 onclick="addItem('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}','{$sCliente->shippingAddress->id_country}')" class="NombreCorto">
                        {$prA.name}{*{$prA.name|count_characters}*}</h4>
                    {/if}

                    {if $prA.name|count_characters:true >= 26 && $prA.name|count_characters:true <=50}
                    <h4 onclick="addItem('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}','{$sCliente->shippingAddress->id_country}')" class="NombreMedio">
                        {$prA.name}{*{$prA.name|count_characters}*}</h4>
                    {/if}


                    {if $prA.name|count_characters:true >= 51}
                    <h4 onclick="addItem('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}','{$sCliente->shippingAddress->id_country}')" class="NombreLargo">
                        {$prA.name}{*{$prA.name|count_characters}*}</h4>
                    {/if}

                    <h3>{$prA.grossUnitPrice} €</h3> 
                    
                    
                    {* Nuevo input *}
                    <div class="input-with-control">
                        <span class="input-number-decrement">–</span>
                            <input name="qty{$prA.productId}{$count}" id="qty{$prA.productId}{$count}" class="input-number" type="text" value="1" min="1" max="10">
                        <span class="input-number-increment">+</span>
                    </div>
                    


                    <a onclick="addItem('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}','{$sCliente->shippingAddress->id_country}')" class="btn btn-product-list boton-add-suscripcion" style="font-size:12px; padding: 5px; margin-top: 5px; margin-bottom: 5px;">{l s='AÑADIR'
                        mod='customsuscripciones'}</a>
                </div>
                </h4>
            </div>
            
            {$count=$count+1}
            {/foreach}
        </div>
    </div>
</div>
