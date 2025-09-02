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

  {block name='page_title'}
  
    <h1 class="historialTitulo">{l s='Historial de pedidos' mod='customhistorico'}</h1>
          {* {l s='Historial de Pedidos' mod='customhistorico'} *}
     
  {/block}

      {block name='page_content'}
      <section id="content" class="style-historico-margins">
        <aside id="notifications">
          <div class="container">
          </div>
        </aside>
        
        {* <div style="border: 2px solid rgba(23,115,67,0.5); padding: 6px;">
         <p>{l s='Amet tellus cras adipiscing enim eu turpis egestas pretium aenean. Pharetra diam sit amet nisl suscipit adipiscing bibendum est ultricies. Ac ut consequat semper viverra nam libero justo laoreet sit.'}</p>
        <p>{l s='Amet tellus cras adipiscing enim eu turpis egestas pretium aenean. Pharetra diam sit amet nisl suscipit adipiscing bibendum est ultricies. Ac ut consequat semper viverra nam libero justo laoreet sit.'
          mod='customhistorico'}</p></div><br>
         *}
       
        {assign var=contadorGeneral value=1}
        {foreach from=$historico item=sCliente}


        <div class="entregaenCurso">
 
            <div class="headerEntregaenCurso" style="display: flex;justify-content: space-between;align-items: center;"> 
              <div>
              <i class="material-icons"></i>
              <div class="color-entrega-etc">
              {l s='Entrega' mod='customhistorico'}: {$sCliente->shippingDate|date_format:"%d/%m/%Y"}
              </div>
              
              <div class="color2-entrega-etc">{$sCliente->slotName}</div>
            </div>
            {if ($sCliente->invoiceId!="null") && ($sCliente->invoiceId!="") }
             <button style="text-transform: uppercase; font-family: 'Roboto', sans-serif; " class="btn button-factura" onclick="descargarFactura('{$sCliente->invoiceId}')">
                <i class="material-icons shopping-cart"></i>
                {l s='Descargar Factura' mod='customhistorico'}&nbsp&nbsp&nbsp<img src="/img/cms/descargar@2x.png" alt="" width="20" height="20"/>

</i>
              </button>
            {/if}

            </div>
            
             

          <div class="addressEntregaenCurso">
            <span  class="headaddressEntrega">{l s='Dirección Entrega:' mod='customhistorico'}</span> <span style="color: #290000;"
              class="bodyaddressEntrega">{$sCliente->shippingAddress->address1} {$sCliente->shippingAddress->city}
              {State::getNameById({$sCliente->shippingAddress->id_state})} - {$sCliente->shippingAddress->postcode}
              {$sCliente->shippingAddress->country}</span>
          </div> 
   
          <div class="listado-productos1">

          {assign var=linea value=1}
          {foreach from=$sCliente->order item=producto}
          {include file="module:customhistorico/views/templates/front/contenidoSimple.tpl" producto=$producto}
          {/foreach}
          <div class="totalEntregaenCurso">
            <div>TOTAL: &nbsp</div> 
            <div class="totalPrecio">{Tools::displayPrice($sCliente->totalAmount,$currency)|escape:'htmlall':'UTF-8'}</div> 
          </div>
        </div>



         
          
 
        </div>




        {$contadorGeneral=$contadorGeneral+1}

        {/foreach}

      </section>

      {/block}


     