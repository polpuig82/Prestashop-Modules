<div class="container-xl">
    
    {* <div class="col-md-12" id="mycarousel"> *}

        <div class="owl-carousel owl-theme basic">
           
           
            {assign var=count value=1}
            {foreach from=$productosrecomendados item=prA}


            <div class="item" style="padding-bottom:80px;">
                
                <div class="carousel-element">
                    
                    <!-- {if $prA.active == 1} -->
                    <img onclick="addItemToOrder('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}','{$pCurso->obId}','{$prA.grossUnitPrice}')"
                        src="{$prA.image}" />
                   
                    {if $prA.name|count_characters:true > 1 && $prA.name|count_characters:true <= 10}
                    <h4 onclick="addItemToOrder('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}','{$pCurso->obId}','{$prA.grossUnitPrice}')" class="NombreMuyCorto">
                        {$prA.name}{*{$prA.name|count_characters}*}</h4>
                    {/if}
                    {if $prA.name|count_characters:true >= 11 && $prA.name|count_characters:true <= 25}
                    <h4 onclick="addItemToOrder('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}','{$pCurso->obId}','{$prA.grossUnitPrice}')" class="NombreCorto">
                        {$prA.name}{*{$prA.name|count_characters}*}</h4>
                    {/if}

                    {if $prA.name|count_characters:true >= 26 && $prA.name|count_characters:true <=50}
                    <h4 onclick="addItemToOrder('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}','{$pCurso->obId}','{$prA.grossUnitPrice}')" 
                        class="NombreMedio">
                        {$prA.name}{*{$prA.name|count_characters}*}</h4>
                    {/if}


                    {if $prA.name|count_characters:true >= 51}
                    <h4 onclick="addItemToOrder('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}','{$pCurso->obId}','{$prA.grossUnitPrice}')" class="NombreLargo">
                        {$prA.name}{*{$prA.name|count_characters}*}</h4>
                    {/if}

                    <h3 id="precio-producto" style="color: #290000;">{$prA.grossUnitPrice|number_format:2:',':'.'} €</h3>
                    
                    {* <input name="qty{$prA.productId}{$count}" id="qty{$prA.productId}{$count}" type="text"
                        class="form-control atc_qty" value="1" onfocus="if(this.value == '1') this.value = '';"
                        onblur="if(this.value == '') this.value = '1';" /> *}
 
                              

                    <div class="input-with-control">
                        <span class="input-number-decrement">–</span>
                            <input name="qty{$prA.productId}{$count}" id="qty{$prA.productId}{$count}" class="input-number" type="text" value="1" min="1" max="10" style="width:45px;">
                        <span class="input-number-increment">+</span>
                    </div>



                  {* <div class="qty">
                        <div class="input-group bootstrap-touchspin">
                            <span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span>
                             


                            <input name="qty{$prA.productId}{$count}" id="qty{$prA.productId}{$count}" type="text"
                                class="form-control atc_qty" value="1" onfocus="if(this.value == '1') this.value = '';"
                                onblur="if(this.value == '') this.value = '1';"/>
                            <span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span>
                            
                            <span class="input-group-btn-vertical">
                                <button class="btn btn-touchspin js-touchspin bootstrap-touchspin-up" type="button">
                                    <i class="material-icons touchspin-up"></i>
                                </button>
                                <button class="btn btn-touchspin js-touchspin bootstrap-touchspin-down" type="button">
                                    <i class="material-icons touchspin-down"></i>
                                </button>
                            </span>
                        </div>
                    </div> *}
                    
                    <a onclick="addItemToOrder('{$prA.productId}','qty{$prA.productId}{$count}','{$contadorGeneral}','{$pCurso->obId}','{$prA.grossUnitPrice}')"
                        class="btn btn-product-list-añadir-corto  boton-add-entrega" 
                        style="font-size:12px; padding: 5px; margin-top: 5px; margin-bottom: 5px;">
                        {l s='AÑADIR' mod='customentregasencurso'}
                    </a>
                    
                    <!-- {/if} -->
                </div>
               
            </div>
            
        
            {$count=$count+1}
            {/foreach}

        
        </div>
    {* </div> *}
</div>