<div class="container-xl">
    <div class="col-md-12" id="mycarousel{$count}">
        <div class="owl-carousel owl-theme basic">
            {assign var=activo value=1}
            {assign var=counter value=1}
            {assign var=key value=0}
            {foreach from=$productosCestaAlternativa item=prA}

            <div class="item">
                <div class="carousel-element">
                    <img onclick="selectItem({$key},{$count})" src="{$prA.image}" />
                    <h4 onclick="selectItem({$key},{$count})"> {$prA.name}</h4>
                </div>
            </div>
            {$key=$key+1}
            {/foreach}
        </div>
    </div>
</div>