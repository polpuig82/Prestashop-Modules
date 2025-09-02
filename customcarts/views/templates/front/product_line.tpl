{if !empty($productosCesta)}
    {l s='Basket content' mod='customcarts'}</h>
    <div class="product-line-info product-line-info-secondary text-muted attribute-periodicidad">
        {foreach from=$productosCesta item=pr}
        <span class="label">{$pr['name']}</span><br/>
    {/foreach}
</div>
{/if}