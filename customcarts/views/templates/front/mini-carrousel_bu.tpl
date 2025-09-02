<div class="container-xl">
    <div class="row">
        <div class="col-md-12">
            <div id="mycarousel{$count}" class="carousel slide" data-ride="carousel" data-interval="0">
                <!-- Carousel indicators -->
                <ol class="carousel-indicators">
                    {assign var=divisor value=count($productosCestaAlternativa)}
                    <li data-target="#mycarousel{$count}" data-slide-to="0" class="active"></li>
                    {assign var=div value=1}
                    {$divisor= $divisor - 6}
                    {while $divisor >= 0}
                    <li data-target="#mycarousel{$count}" data-slide-to="{$div}"></li>
                    {$div=$div+1}
                    {$divisor= $divisor - 6}
                    {/while}

                </ol>
                <!-- Wrapper for carousel items -->
                <div class="carousel-inner">
                    {assign var=activo value=1}
                    {assign var=counter value=1}
                    {assign var=key value=0}
                    {foreach from=$productosCestaAlternativa item=prA}
                    {if $counter == 1 && $activo==0}
                    <div class="item carousel-item">
                        <div class="row carousel-list">
                            {/if}

                            {if $counter == 1 && $activo==1}
                            <div class="item carousel-item active">
                                <div class="row carousel-list">
                                    {assign var=activo value=0}
                                    {/if} 

                                    <!-- Carousel item -->
                                    <div class="carousel-element">
                                        <img onclick="selectItem({$key},{$count})" src="{$prA.image}" />
                                        <h4 onclick="selectItem({$key},{$count})"> {$prA.name}</h4>
                                        <a onclick="selectItem({$key},{$count})" class="btn btn-primary">{l s='Select'
                                            mod='customcarts'}</a>
                                    </div>

                                    {if $counter == 6}
                                </div>
                            </div>
                            {assign var=counter value=0}

                            {/if}
                            {$counter=$counter+1}
                            {$key=$key+1}
                            {/foreach}

                            {if $counter >= 2}
                        </div>
                    </div>
                    {/if}






                    <!-- Carousel controls -->
                    <a class="carousel-control-prev" href="#mycarousel{$count}" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a class="carousel-control-next" href="#mycarousel{$count}" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>