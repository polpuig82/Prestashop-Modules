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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2022 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
 {extends file='customer/page.tpl'}





 {* {block name='page_title'}
 
           {l s='Deliveries in Progress' mod='customentregasencurso'}
 
 {/block} *}
 
 {block name='page_content'}
     
 
 <section id="contenido-sus" class="page-content" >
 <div class="modal fade" id="modalAnadirProductCashback" tabindex="-1" role="dialog" aria-labelledby="examplemodalAnadirProductCashback" aria-hidden="true">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="examplemodalAnadirProductCashback">Advertencia</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
         <p>{l s='Descuento Mi tarjeta Disfrutista ya aplicado, si quieres hacer algún cambio en tu entrega, elimínalo y vuelve a aplicarlo tras finalizar' mod='customentregasencurso'}</p>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
         {* <button type="button" class="btn btn-primary">Save changes</button> *}
       </div>
     </div>
   </div>
 </div>
 
 <div style="display: inline-block; vertical-align: top; margin-bottom: 20px;">
   <div style="display: inline-block;">
   <img src="/img/cms/usuario-account.png" alt="user" width="18" height="18" />
 </div>
 <div style="display: inline-block;">
   <h4>Hola&nbsp{$customer.firstname}</h4>
 </div>
 </div>
 <br>
 <aside id="notifications">
   <div class="container">
    </div>
 </aside>
 <div id="customcashback_entregasencurso">
 <div>
   <p>{l s='Queremos adaptarnos al máximo a tus necesidades y a las de tu familia, así como hacer de la compra un momento ágil y sencillo. Por eso, desde esta página podrás… ' mod='customentregasencurso'}</p>
   <ul>
     <li>- {l s='Modificar tu cesta a tu gusto.' mod='customentregasencurso'}</li>
     <li>- {l s='Añadir productos en tu próxima entrega' mod='customentregasencurso'}</li>
     <li>- {l s='Aprovechar las ofertas exclusivas que ponemos al alcance de los suscriptores.' mod='customentregasencurso'}</li>
   </ul>
   <br/>
   <h3>{l s='¿Quieres añadir productos a tu suscripción?' mod='customentregasencurso'}</h3>
   <p>{l s='Hazlo desde la página de' mod='customentregasencurso'} <a style="text-decoration: underline;" href="/es/module/customsuscripciones/suscripcioneslist">{l s='Suscripciones' mod='customentregasencurso'}</a> {l s='y los incluiremos en tus pedidos periódicos.' mod='customentregasencurso'}</p>
   <br/>
 </div>
 {if isset($CashBack.error) && $CashBack.error}
 {else}
   <div class="col-sm-6 col-md-12 col-lg-4">
                  <div  class="saldo_customer" style="{if isset($CashBack.error)}
                   {if $CashBack.error}
                       display:none;
                   {else}
                       display:block;
                   {/if}
               {else}
                   <!-- Handle the case where 'error' is not set -->
               {/if}" >
                     <h2 style="color:white;font-size:1.25rem;font-weight: inherit;
     text-align: inherit;
     text-transform: inherit;
     margin: inherit;">{l s='Mi tarjeta Disfrutista' mod='customentregasencurso'}</h2>
                     <h1 class="balanceCashback"><img src="/img/cms/currency.webp" alt="marker icono" class="img-cashback" > {$CashBack.balance|number_format:2} €</h1>
                     <p>{l s='Último movimiento:' mod='customentregasencurso'} {$CashBack.lastMovement|date_format:"%d/%m/%Y"}</p>
                     <p>{l s='Fecha de caducidad:' mod='customentregasencurso'}  {$CashBack.expirationDate|date_format:"%d/%m/%Y"}</p>
                     {* {$CashBack.cashbackProduct|dump} *}
                     {* {$pedidosencurso[0]|dump} *}
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
                              <p style="background-color:#9f3c30;font-weight:bold;"> {l s='Descuento Mi tarjeta Disfrutista ya aplicado, si quieres hacer algún cambio en tu entrega, elimínalo y vuelve a aplicarlo tras finalizar' mod='customentregasencurso'}</p>
                           {else}
                           {if $CashBack.balance > 0}
                             {assign var="count" value=0}
                               <input  name="qty{$CashBack.cashbackProduct}{$count}" id="qty{$CashBack.cashbackProduct}{$count}" class="input-number" type="hidden" value="1">
                                     {assign var=contadorGeneral2 value=1}
 
                                    {assign var="firstButtonShown" value=false}
 
                                         {foreach from=$pedidosencurso item=pedido}
                                             {if !$firstButtonShown && $pedido->status == 'DR'}
                                                 <a class="btn" id="hideButton_Cashback" style="color: white; background: #9f3c30; border: 2px solid;width:100%;"
                                                   onclick="addItemToOrder('{$CashBack.cashbackProduct}','qty{$CashBack.cashbackProduct}{$count}','{$contadorGeneral2}','{$pedido->obId}')">
                                                     {l s='Aplicar saldo' mod='customentregasencurso'}
                                                 </a>
                                                 {assign var="firstButtonShown" value=true}
                                             {else}
                                                 {$contadorGeneral2=$contadorGeneral2+1}
                                             {/if}
                                         {/foreach}
 
                          
                           {else}
                             {/if}
                           {/if}
 {* {$CashBack.balance|@dump} *}
 
                   </div>
                         </div></div>{/if}
  </div>  
    <br></br>
  {*Mensaje de retorno de llamada (desaparece solo)*}
   <div id="hideDiv" class="mensaje-temporal-container">
     <div class="mensaje-retorno">Petición procesada correctamente </div>                    
   </div>
 
   {* Spinner loading *}
   <div class="spinner-container">
       <div class="spinner-content">
 
           <div class="spinner-title">{l s='Notificando cambios a nuestro Huerto' mod='customentregasencurso'}</div>
           <div class="loader"></div>
       </div>
   </div>
 
 
   {* Pop up emergente de confirmación de cambios *}
   <div class="confirm">
       <div></div>
       <div>
       <div id="confirmMessage">Confirm text</div>
       <div>
           <input id="confirmYes" type="button" value="Aplicar Cambios" />
           <input id="confirmNo" type="button" value="Cancelar" />
       </div>
       </div>
   </div>
 
 {assign var=contadorGeneral value=1}
 
 <div class="elContenedorPrincipal">
 {foreach from=$pedidosencurso item=pCurso}
 
 <script>
             var arrayPedido{$contadorGeneral}=[];
         </script>
  
 
 
    {if $pCurso->status!="DR"}
 
     <div class="entregaenCurso">
     {else}  
     <div class="entregaenCursoDR">
     {/if}
     
 {if $pCurso->status!="DR"}
     <div class="title-proxima">
       <img src="/img/cms/transporte_refrig.png" alt="" width="58" height="43"/>
       &nbsp&nbsp{l s='Tu próxima entrega:' mod='customentregasencurso'}
     </div>
     <div class="headerEntregaenCurso">
     {l s='Entrega Prevista' mod='customentregasencurso'} {$pCurso->shippingDate|date_format:"%d/%m/%Y"} ({$pCurso->slotName})
     </div>
 {if $pCurso->status!="DR"}
     <div class="alertEntrega">
       {l s='On progress - Unmodifiable' mod='customentregasencurso'}
     </div>
 {else}
     <div style="color:#9F3C30">
       <h4>Editable</h4>
     </div>
 {/if}
     <div class="addressEntregaenCurso">
 {if $pCurso->status!="DR"}
     <span class="modifyEntregaenCurso">
 {*{l s='No se puede modificar' mod='customentregasencurso'}*}</span>
 {/if}
     <div class="headerEntregaenCurso">
     {$pCurso->totalAmount|number_format:2:',':'.'}€
     </div>
      <span class="headerEntregaenCurso">{l s='Dirección Entrega:' mod='customentregasencurso'}</span> 
      <span class="headerEntregaenCurso">{$pCurso->shippingAddress->address1} {$pCurso->shippingAddress->city} {State::getNameById({$pCurso->shippingAddress->id_state})} - {$pCurso->shippingAddress->postcode} {$pCurso->shippingAddress->country}</span>
     </div>
 
 {else}
 <div class="title-proxima2"><img src="/img/cms/transporte_siguiente.png" alt="" width="58" height="43"/></i>&nbsp&nbsp{l s='Tu siguiente entrega:' mod='customentregasencurso'}</div>
 <div class="headerEntregaSiguiente"> <i class="material-icons"></i>
     {l s='Entrega Prevista' mod='customentregasencurso'} {$pCurso->shippingDate|date_format:"%d/%m/%Y"} ({$pCurso->slotName})
     </div>
     {if $pCurso->status!="DR"}
     <div class="alertEntrega">{l s='Esta entrega ya se ha registrado y no se puede modificar' mod='customentregasencurso'}</div>
     {else}
     <div style="color:#9F3C30;display:flex;" >
       <h4>Editable</h4> <p style="margin-left:5px;">{l s='(Recuerda que estás modificando tus próximas entregas, si quieres modificar tu suscripción haz clic' mod='customentregasencurso'} <a  style="color:#9F3C30" href="/module/customsuscripciones/suscripcioneslist" >aquí)</a> </p>
 
 
     </div>
     {/if}
     <div class="addressEntregaenCurso">
     {if $pCurso->status!="DR"}
     <span class="modifyEntregaenCurso">
 {*{l s='No se puede modificar' mod='customentregasencurso'}*} <i class="material-icons"></i></span>
     {/if}
     <div class="headerEntregaSiguiente">
 
 
     </div>
      <span class="headerEntregaSiguiente">{l s='Dirección Entrega:' mod='customentregasencurso'}</span> <span class="headerEntregaSiguiente">{$pCurso->shippingAddress->address1} {$pCurso->shippingAddress->city} {State::getNameById({$pCurso->shippingAddress->id_state})} - {$pCurso->shippingAddress->postcode} {$pCurso->shippingAddress->country}</span>
     </div>
 
 
 {/if}
 
 
       <div class="">
         {if $pCurso->status!="DR"}
         
   <div id="show">
     <strong>{l s='View content' mod='customentregasencurso'}</strong>
     </div>
     <div class="menu" style="display: none;">
             {include file="module:customentregasencurso/views/templates/front/contenidoPedido.tpl" pCurso=$pCurso}
           </div>
         {else}
         {* Lo gordo*}
             {include file="module:customentregasencurso/views/templates/front/modificarPedido.tpl" pCurso=$pCurso cG=$contadorGeneral}
         {/if}
     </div>
     <div class="totalEntregaenCurso totalEntregaenCurso{$pCurso->obId}" id="total{$contadorGeneral}">
    <div style="display: inline-block; text-align: left;"><h6>TOTAL:&nbsp</h6></div>
    <div style="display: inline-block; text-align: right;"><h6>{$pCurso->totalAmount|number_format:2:',':'.'} €</h6></div>
     </div>
     </div>
 
     
 
 
 
  {$contadorGeneral=$contadorGeneral+1}
 
 {/foreach}
 </div>
   </section>
   {literal}
       <style>
       #content_box_welcome{
         margin-top:8%;
         
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
         margin-bottom:1%;
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
  @media screen and (min-width: 200px) and (max-width: 800px) { 
 
 #customcashback_entregasencurso{
        display:inline;
       }
  }
 @media screen and (min-width: 800px) and (max-width: 1500px) { 
 
#customcashback_entregasencurso{
           display:inline;
       }
  }
  @media screen and (min-width: 1500px) and (max-width: 3000px) { 
 
    #customcashback_entregasencurso{
           display:flex;
       }
     }
     .negative_cashback{
         color: #9f3c30;
 
     }
       </style>



       <script>
  function iniciarAutoClick() {
    console.log("Evento load disparado");
    const params = new URLSearchParams(window.location.search);
    console.log("Valor de autoClick:", params.get("autoClick"));
    if (params.get("autoClick") === "true") {
     // console.log("Parámetro autoClick detectado. Iniciando auto click.");
      let attempts = 0;
      const maxAttempts = 300; // 300 intentos (aprox. 30 segundos)
      const intervalId = setInterval(() => {
        attempts++;
      //  console.log("Intento autoClick:", attempts);
        const btn = document.getElementById("hideButton_Cashback");
        if (btn) {
          if (typeof window.addItemToOrder === "function") {
          //  console.log("Botón y función detectados. Ejecutando click.");
            btn.click();
            // Elimina el parámetro autoClick de la URL para evitar que se dispare al recargar.
            if (window.history && typeof window.history.replaceState === "function") {
              const url = new URL(window.location);
              url.searchParams.delete("autoClick");
              window.history.replaceState({}, document.title, url.toString());
            }
            clearInterval(intervalId);
          } else {
          //  console.log("Botón encontrado, pero addItemToOrder aún no está definida.");
          }
        } else {
         // console.log("Botón con id 'hideButton_Cashback' no encontrado.");
        }
        if (attempts >= maxAttempts) {
        //  console.warn("Se alcanzó el número máximo de intentos sin éxito.");
          clearInterval(intervalId);
        }
      }, 100); // Verifica cada 100 ms
    }
  }

  if (document.readyState === "complete") {
    iniciarAutoClick();
  } else {
    window.addEventListener("load", iniciarAutoClick);
  }
</script>
      {/literal} 
 
 {/block}
 
 
 