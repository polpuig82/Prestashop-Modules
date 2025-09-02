{**
* 2007-2020 PrestaShop and Contributors
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License 3.0 (AFL-3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/AFL-3.0
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* @author PrestaShop SA <contact@prestashop.com>
  * @copyright 2007-2022 PrestaShop SA and Contributors
  * @license https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
  * International Registered Trademark & Property of PrestaShop SA
  *}
  {extends file='customer/page.tpl'}
{include file='module:customcashback/views/templates/front/displaySaldo.tpl' cashback=$CashBack}

  {block name='page_title'}
  
    <h1 class="historialTitulo">{l s='Mi tarjeta Disfrutista' mod='customcashback'}</h1>
          {* {l s='Historial de Pedidos' mod='customhistorico'} *}
     
  {/block}

      {block name='page_content'}

          {if isset($CashBack) && is_array($CashBack) && !isset($CashBack.error)}
            <div style="{if $CashBack.esDescription}display:block;{else}display:none;{/if}">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <div id="content_box_welcome">
                      <div class="welcome_text_p">
                      <div>
                        <h3>{l s='Hola de nuevo' mod='customcashback'} {$customer.firstname}:</h3>
                        {if $language.iso_code == 'es'} {$CashBack.esDescription}
                        {elseif $language.iso_code == 'ca'} {$CashBack.caDescription}
                        {else} {$CashBack.esDescription}
                        {/if}
                    </div>

                        <h4>{l s='Este es el resumen de tu saldo' mod='customcashback'}</h4>
                        <span>{l s='¡Qué tengas un buen día!' mod='customcashback'}</span>
                          <br></br>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    {* <img src="/img/cms/sandia.png" style="margin-left:37%;" alt="marker icono" width="150" height="150"> *}
                  </div>
                </div>
              </div>


              <div class="row" >
                <div class="col-md-6">
                  <div class="saldo_customer">
                    <h2>{l s='Mi tarjeta Disfrutista' mod='customcashback'}</h2>
                    <h1><img src="/img/cms/currency.webp" alt="marker icono" class="img-cashback" > {$CashBack.balance|number_format:2} €</h1>
                    <p>{l s='Último movimiento:' mod='customcashback'} {$CashBack.lastMovement|date_format:"%d/%m/%Y"}</p>
                    <p>{l s='Fecha de caducidad:' mod='customcashback'}  {$CashBack.expirationDate|date_format:"%d/%m/%Y"}</p>

                    {assign var="productFound" value=false}
                      {foreach $pedidosencurso as $order}
                          {foreach $order->order as $item}
                              {if $item.productId == $CashBack.cashbackProduct}
                                  {assign var="productFound" value=true}
                              {/if}
                          {/foreach}
                      {/foreach}

                      <div id="saldo_customer_ajax">
                          {if $productFound}
                              <p style="background-color:#9f3c30;font-weight:bold;">
                                  {l s='Descuento Mi tarjeta Disfrutista ya aplicado, si quieres hacer algún cambio en tu entrega, elimínalo y vuelve a aplicarlo tras finalizar' mod='customentregasencurso'}
                              </p>

                          {elseif $CashBack.balance > 0}
                              {assign var="count" value=0}
                              <input
                                  name="qty{$CashBack.cashbackProduct}{$count}"
                                  id="qty{$CashBack.cashbackProduct}{$count}"
                                  class="input-number"
                                  type="hidden"
                                  value="1"
                              >
                              {assign var="contadorGeneral2" value=1}
                              {assign var="firstButtonShown" value=false}

                              {foreach from=$pedidosencurso item=pedido}
                                  {if !$firstButtonShown && $pedido->status == 'DR'}
                                      {* <a
                                          class="btn"
                                          id="hideButton_Cashback"
                                          style="color: white; background: #9f3c30; border: 2px solid; width:100%;"
                                          onclick="addItemToOrder(
                                              '{$CashBack.cashbackProduct}',
                                              'qty{$CashBack.cashbackProduct}{$count}',
                                              '{$contadorGeneral2}',
                                              '{$pedido->obId}'
                                          )"
                                      >
                                          Aplicar saldo
                                      </a> *}

                                      <button class="btn" id="btnGotoPage2" style="color: white; background: #9f3c30; border: 2px solid;width:100%;">{l s='Aplicar saldo' mod='customentregasencurso'}</button>
                                      {assign var="firstButtonShown" value=true}
                                  {else}
                                      {assign var="contadorGeneral2" value=$contadorGeneral2+1}
                                  {/if}
                              {/foreach}

                          {/if}

                          {* {$CashBack.balance|@dump} *}
                      </div>

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="other_info">
                    <p>{l s='¡Sigue acumulando saldo con cada pedido realizado!' mod='customcashback'}</p>
                    <p>{l s='¡Podrás canjearlo por descuentos en tus próximas compras!' mod='customcashback'}</p>
                    <a class="btn btn-primary" href="/">{l s='Seguir Comprando' mod='customcashback'}</a>
                  </div>
                </div>
              </div>
              <div class="container">
                <h2>{l s='Transacciones' mod='customcashback'}</h2>
                <table class="table" style="text-align:end;">
                  <thead>
                    <tr>
                      <th style="text-align:center;">{l s='Fecha' mod='customcashback'}</th>
                      <th style="text-align:center;">{l s='Concepto' mod='customcashback'}</th>
                      <th style="text-align:center;">{l s='Pedido' mod='customcashback'}</th>
                      <th>{l s='Importe' mod='customcashback'}</th>
                      <th>{l s='Saldo' mod='customcashback'}</th>
                    </tr>
                  </thead>
                  <tbody>
                    {foreach $CashBack.transaciones as $transaccion}
                      <tr>
                        <td style="text-align:center;">{$transaccion.date|date_format:"%d/%m/%Y"}</td>
                        <td style="text-align:center;">{$transaccion.description}</td>
                        <td style="text-align:center;">{$transaccion.salesOrder}</td>
                        <td>

                          {if $transaccion.amount < 0}
                              <span class="negative_cashback">{$transaccion.amount|number_format:2} €</span>
                              {else}
                              {$transaccion.amount|number_format:2} €
                          {/if}
                        </td>
                        <td>{$transaccion.balance|number_format:2} €</td>
                      </tr>
                    {/foreach}
                  </tbody>
                </table>
              </div>
            </div>
          {else}
            <div id="error_cashback">
                <br>
                {if $CashBack.error}
                    {$CashBack.error} <a href="/content/10-contacto">aquí</a>
                {/if}
            </div>
          {/if}

       {literal}
      <style>
      #content_box_welcome{
        margin-top:6%;
        
      }
      .welcome_text_p{
        margin-top:3%;
        margin-right:3%;
      }
      .saldo_customer{
        display: flex;
       flex-direction: column;
       background-color:#177343;
        color:white;
        padding:1rem;
        margin-bottom:10%;
        border-radius: 15px;
        width: 80%;
      }
      .other_info{
        text-align:center;
        margin-top:5%;
      }
      
      @media screen and (min-width: 200px) and (max-width: 800px) { 

.img-cashback{
       display:none;
      }
 }
@media screen and (min-width: 800px) and (max-width: 1500px) { 

.img-cashback{
        width:30px;
        height:30px;
      }
 }
 @media screen and (min-width: 1500px) and (max-width: 3000px) { 

   .img-cashback{
        width:30px;
        height:30px;
      }
    }

    .negative_cashback{
        color: #9f3c30;

    }
      </style>

       <script>
      
  document.getElementById("btnGotoPage2").addEventListener("click", function() {
    // Al hacer clic, rediriges con un parámetro indicando "autoClick"
    window.location.href = "/module/customentregasencurso/deliveriesinprogress?autoClick=true";
  });
</script>

     {/literal} 



      {/block}


  