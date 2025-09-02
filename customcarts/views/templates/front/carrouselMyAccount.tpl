

<div class="container-xl">
    <div class="row">
        <div class="col-md-12">
            <h2>{l s='select the item you want to change in the basket ' mod='customcarts'}</h2>
            <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0">
                <!-- Carousel indicators -->
                <ol class="carousel-indicators">
                    {assign var=divisor value=count($productosCestaAlternativa)}
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    {assign var=div value=1}
                    {$divisor= $divisor - 4}
                    {while $divisor >= 0}
                        <li data-target="#myCarousel" data-slide-to="{$div}"></li>
                        {$div=$div+1}
                        {$divisor= $divisor - 4}
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
                        <div class="row">
                            {/if}

                            {if $counter == 1 && $activo==1}
                            <div class="item carousel-item active">
                                <div class="row">
                                    {assign var=activo value=0}
                                    {/if}

                                    <div class="col-sm-3">
                                        <div class="thumb-wrapper">
                                            <div class="img-box">
                                                <img src="{$prA.image}"/>
                                            </div>
                                            <div class="thumb-content">
                                                <h4> {$prA.name}</h4>
                                                <a onclick="selectItemMyAccount({$key})" class="btn btn-primary">{l s='Select' mod='customcarts'}</a>
                                            </div>
                                        </div>
                                    </div>
                                    {if $counter == 4}
                                </div></div>
                            {assign var=counter value=0}

                            {/if}
                            {$counter=$counter+1}
                            {$key=$key+1}
                            {/foreach}

                            {if $counter >= 2}
                        </div></div>
                    {/if}






                    <!-- Carousel controls -->
                    <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a class="carousel-control-next" href="#myCarousel" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>

                </div>
            </div>
        </div>
