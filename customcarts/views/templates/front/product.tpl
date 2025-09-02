<script>
    var productosCestaDefinida={$productosCestaDefinida|@json_encode nofilter};
    var productosCestaAlternativa={$productosCestaAlternativa|@json_encode nofilter};
    var control={$control};

</script>

</h3> {l s='Basket content' mod='customcarts'}</h3>
{assign var=count value=1}
{foreach from=$productosCestaDefinida item=prD}
<div class="boxItemEditor" id="precognis{$count}">
    <div class="editableItemFrame">
        <div class="image">
            <img src="{$prD.image}"/>
        </div>
        {if $prD.intercambiable!=0}
        <a class="btn btn-primary definido" data-toggle="modal" data-target="#modalCarrousel" data-elemento-id="{$count}">
            <i class="fa fa-repeat"></i></a>
        {/if}
        {$prD.name}
            <input type="hidden" id="ElementoCestaInp{$count}" name="ElementoCestaInp{$count}" value="{$prD.componente}">
    </div>
{$count=$count+1}


</div>
    {/foreach}

<!-- Modal -->
<div class="modal fade" id="modalCarrousel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="index.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{l s='Select Article Change' mod='customcarts'}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="idCambio" name="idCambio">
                        {include file="./carrousel.tpl" productosCestaAlternativa=$productosCestaAlternativa}
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




