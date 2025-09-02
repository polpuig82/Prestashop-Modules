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

    {* {block name='page_title'}

    
                    {l s='Suscripciones' mod='customsuscripciones'}
          
            {/block} *}

            {block name='page_content'}


            <section id="content" class="page-content padding-right-content">
            <div class="title-suscripciones"></i>{l s='Suscripciones' mod='customsuscripciones'}</div>
                <aside id="notifications">
                    <div class="container">
                    </div>
                </aside>
                

                {*Mensaje de retorno de llamada (desaparece solo)*}
                <div id="hideDiv" class="mensaje-temporal-container">
                    <div class="mensaje-retorno"></div>                    
                </div>

                {* Spinner loading *}
                <div class="spinner-container">
                    <div class="spinner-content">

                        <div class="spinner-title">Estamos actualizando tu suscripción. Este proceso puede tardar hasta 1 minuto, por favor, no cierres tu  navegador.</div>
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


                <br/>
                <div class="border-text-prin">
                    <h3 class="titulosTextoMobile">{l s='¿Quieres añadir productos a tu suscripción?' mod='customsuscripciones'}</h3>
                    <br/>
                    <p class="textosMobile">{l s='Solo debes clicar el botón Añadir productos que aparece en el margen superior derecho de tu suscripción. Más fácil… ¡imposible!' mod='customsuscripciones'}</p>
                    <br/>
                    <h3 class="titulosTextoMobile">{l s='¿Quieres cancelar tu próxima entrega?' mod='customsuscripciones'}</h3>
                    <br/>
                    <p class="textosMobile">{l s='Puedes cancelarla pulsando el botón que aparece justo al lado de la fecha prevista de entrega. Tu próxima cesta se programará para la siguiente entrega contemplada dentro de tu plan de suscripción.' mod='customsuscripciones'}</p>
                    <br/>
                    <h3 class="titulosTextoMobile">{l s='¿Te gustaría añadir productos a tu próxima entrega?' mod='customsuscripciones'}</h3>
                    <br/>
                    <p class="textosMobile">{l s='Hazlo desde la página de' mod='customsuscripciones'} <a style="text-decoration: underline" href ="/es/module/customentregasencurso/deliveriesinprogress">{l s= 'Próximas entregas' mod='customsuscripciones'}</a> <span>{l s='y los incluiremos en tu próximo pedido.' mod='customsuscripciones'}</p>
                    <br/>
                    <h3 class="titulosTextoMobile">{l s='¿Deseas modificar o cancelar tu suscripción?' mod='customsuscripciones'}</h3>
                    <br/>
                    <p class="textosMobile">{l s='La cancelación del pedido o suscripción deberá notificarse con un mínimo de 72 horas laborables de antelación enviando un correo a hola@disfrutaverdura.com. En caso contrario, se aplicará un cargo de 10 € en concepto de transporte y manipulación.' mod='customsuscripciones'}</p>
                
                </div>
                
                {assign var=contadorGeneral value=1}
                {foreach from=$suscripciones item=sCliente}

                <script>
                    var arrayPedido{$contadorGeneral} = [];


                    var arrayLineas{$contadorGeneral} = {$sCliente->lineasEstado|@json_encode nofilter};
                </script>
              

                <div class="entregaenCurso">
                    <div class="header-suscripcion-box" > 
                       
                            <div style="display:flex;">
                               <h2>{l s='Entrega Prevista' mod='customsuscripciones'}
                            {$sCliente->deliveryDate|date_format:"%d/%m/%Y"}</h2>
                          <div class="toggle-box">
                        {if $sCliente->status=='NO'}
                        {*  Switch por defecto es si y se puede cambiar a no *}
                        <label class="switch" >
                            <input type="checkbox" checked
                                onclick="switchEstado('{$contadorGeneral}','{$sCliente->lineId}',this)">
                            <span class="slider round">  </span> 
                        </label>
                        <label style="color:#290000!important;">{l s='Activa' mod='customsuscripciones'}</label>
                        {/if}

                        {if $sCliente->status=='NA'}
                        {*  Switch por defecto es si y no se puede cambiar *}
                        <label class="switch">
                            <input type="checkbox"  onclick="switchEstado('{$contadorGeneral}','{$sCliente->lineId}',this)">
                            <span class="slider round"></span> 
                        </label>
                        <label>{l s='Desactivada' mod='customsuscripciones'}</label>

                        {/if}

                           {if $sCliente->status=='FO'}

                            <div class="alertEntrega">
                        {l s='Texto XXXX para FO' mod='customsuscripciones'}
                            </div>

                        {/if}

                          {if $sCliente->status!='NA' and $sCliente->status!='NO' and $sCliente->status!='FO'}
                       {*  Switch por defecto es si y no se puede cambiar *}
                        <label class="switch">
                            <input type="checkbox" disabled>
                            <span class="slider round"></span>
                        </label>
                        <label>{l s='Desactivada' mod='customsuscripciones'}</label>

                        {/if}
                        {foreach from=$sCliente->order item=producto}

                        {* <div class="producto-toggle-box">

                            {include file="module:customsuscripciones/views/templates/front/contenidoSimple.tpl"
                            producto=$producto}

                        </div> *}
                        {/foreach}





                    </div>
                        </div>

                        {if $sCliente->status=='NO'}
                        <button class="btn btn-primary" onclick="desplegarAnnadirPedido({$contadorGeneral})" style="float: right;">
                            <i class="material-icons shopping-cart"></i>
                            {l s='Añadir Productos' mod='customsuscripciones'}
                        </button>
                        {/if}
                    </div>

                    <div class="headerEntregaenCurso">
                       <span style="color: #9F3C30;    font-weight: 400;"> {l s='Recuerda que únicamente estás cancelando/activando tu próxima entrega' mod='customsuscripciones'}</span>
                    </div>
                    
                    <div class="addressEntregaenCurso">
                        <span class="headaddressEntrega">{l s='Dirección Entrega:' mod='customsuscripciones'}</span>
                        <span class="bodyaddressEntrega">{$sCliente->shippingAddress->address1}
                            {$sCliente->shippingAddress->city}
                            {State::getNameById({$sCliente->shippingAddress->id_state})} -
                            {$sCliente->shippingAddress->postcode} {$sCliente->shippingAddress->country}
                            </span>
                    </div>


                    {*Contenido*}
                    <h3>{l s='Contenido: ' mod='customsuscripciones'}</h3>



                    <div class="listado-productos1">

                        {assign var=linea value=1}
                        {foreach from=$sCliente->order item=producto}
                        {include file="module:customsuscripciones/views/templates/front/contenidoSimple.tpl"
                        producto=$producto}
                        <script>
                            general = {$contadorGeneral};
                            nid = {$producto['productId']};
                            nname = '{$producto['name']}';
                            nqty = {$producto['quantity']};
                            var nodo = {
                                "id": nid,    //your artist variable
                                "quantity": nqty,    //your artist variable
                                "name": nname,    //your artist variable
                            };
                        arrayPedido{$contadorGeneral}.push(nodo);
                        </script>
                        {/foreach}

                        {* aquiii : contenido de entrega en curso  *}
                        <div class="extra" id="extra{$contadorGeneral}"> </div>

                    </div>

                    <div class="" id="appchanges{$contadorGeneral}" style="display:none">
                        <a class="btn btn-product-list" style="width: 40%; text-transform: uppercase; font-weight: 600; margin-top:20px; align-content: center; "
                            onclick="aplicarCambios('{$contadorGeneral}','{$sCliente->obId}')">{l s='Save' mod='customsuscripciones'}</a>
                    </div>



                    {*Contenido*}
                    {* <div class="headerEntregaenCurso">
                        <div>

                            <i class="material-icons"></i>
                            {l s='Entrega Prevista' mod='customsuscripciones'}
                            {$sCliente->subscriptionDate|date_format:"%d/%m/%Y"}
                        </div>

                    </div> *}

                    

                    {if $sCliente->status!="NO"}
                    <div class="alertEntrega">
                        {l s='La entrega con fecha ' mod='customsuscripciones'}{$sCliente->deliveryDate|date_format:"%d/%m/%Y"}{l s=' ha sido cancelada.' mod='customsuscripciones'}
                    </div>
                    {/if}


                    <div class="row carrucontent" id="main-mini-carrousel-box id">
                        <div class="carruselfondo" id="carrouseladdPedido{$contadorGeneral}">

              <div class="carrutitle">
                {if $id_lang==1}
                    {$tituloCarrouselSuscripciones1_ES}
                    {else}
                    {$tituloCarrouselSuscripciones1_CA}
                {/if}
               
            </div>
            <div class="carrusubtitle">      
                {if $id_lang==1}
                    {$descCarrouselSuscripciones1_ES}
                {else}
                    {$descCarrouselSuscripciones1_CA}
                {/if}
            </div>
                            {include file="module:customsuscripciones/views/templates/front/mini-carrouselAddPedido.tpl"
                            productosrecomendados=$productossuscripcion1}

            {* <div class="carrutitle">
                {if $id_lang==1}
                    {$tituloCarrousel2_ES}
                    {else}
                    {$tituloCarrousel2_CA}
                {/if}
            </div>
            <div class="carrusubtitle">
                {if $id_lang==1}
                    {$descCarrousel2_ES}
                {else}
                    {$descCarrousel2_CA}
                {/if}
            </div>
                            {include file="module:customsuscripciones/views/templates/front/mini-carrouselAddPedido.tpl"
                            productosrecomendados=$productosrecomendados2} *}

           {* <div class="carrutitle"> *}
           {* {$tituloCarrousel3} *}
                 {* {if $id_lang==1}
                    {$tituloCarrousel3_ES}
                {else}
                    {$tituloCarrousel3_CA}
                {/if} 
           </div>

        <div class="carrusubtitle"> *}

            {* {$descCarrousel3} *}
                 {* {if $id_lang==1}
                    {$descCarrousel3_ES}
                {else}
                    {$descCarrousel3_CA}
                {/if} 
            </div>
                            {include file="module:customsuscripciones/views/templates/front/mini-carrouselAddPedido.tpl"
                            productosrecomendados=$productosrecomendados3}
                          <div>
                <div class="carrutitle">
                    {$tituloCarrousel4}
                </div>
                <div class="carrusubtitle">
                    {$descCarrousel4}
                </div>
                {include file="module:customsuscripciones/views/templates/front/search/search-products.tpl" contadorGeneral=$contadorGeneral productosrecomendados=$productosrecomendados4}
            </div> *}
                         </div>

                
                    </div>



                </div>
{*TEST*}
                {$contadorGeneral=$contadorGeneral+1}

                {/foreach}


                    <div class="row col-lg-12 col-md-6 col-sm-6" style="margin-bottom:20%;  background-color: #ffffff;">
                        <div class="form-padding-margin" >
                              <h4 style="font-family: lora; font-weight: 700;color: #177343; padding-top:15px;"> 
                        {l s='¿Quieres realizar uno de estos cambios en tu suscripción?' mod='customsuscripciones'}
                        
                        <li style="color:black; margin-left:2%; margin-top:10px;">{l s='Pausar suscripción ' mod='customsuscripciones'}</li>
                        <li style="color:black; margin-left:2%;">{l s='Cambiar frecuencia ' mod='customsuscripciones'}</li>
                        <li style="color:black; margin-left:2%;">{l s='Cambiar dirección de la suscripción ' mod='customsuscripciones'}</li>
                        <li style="color:black; margin-left:2%; margin-bottom:10px;">{l s='Cambiar/añadir o cancelar un producto suscrito ' mod='customsuscripciones'}</li>
                     
                        </h4>
                        <p style="margin-top: 10px; color:#290000;"><strong>{l s='Ponte en contacto' mod='customsuscripciones'}</strong></p>
                        <hr>
                        <div>
                                                       <div style="margin-top: 25px;">
                                                       <img src="/img/cms/contacto.png" alt="" width="25" height="24"/>
                                                       <span style="margin-top: 10px; color:#290000;"><strong>&nbsp&nbsp{l s='Call us' d='Shop.Theme.Customeraccount'}</strong></span><br>
                                                       <span style="margin-top: 10px; color:#290000; margin-left: 30px;">{l s='Lunes a Jueves, 9:00h a 18:00h' d='Shop.Theme.Customeraccount'}</span><br>
                                                       <span style="margin-top: 10px; color:#290000; margin-left: 30px;">{l s='Viernes, 8:00h a 15:00h' d='Shop.Theme.Customeraccount'}</span><br>
                                                      <div style="margin-bottom: 10px;margin-top:12px;">
                                               <span style="color: #000000; margin-left: 30px;">Empresas - </span>
                                               <a href="tel:674211897" style="color: #46735c; text-decoration: underline;">
                                               674 211 897
                                             </a>
                                             </div>
                                             <div style="margin-bottom: 10px;">
                                               <span style="color: #000000; margin-left: 30px;">Particulares - </span>
                                               <a href="tel:674211907" style="color: #46735c; text-decoration: underline;">
                                                 674 211 907
                                               </a>
                                             </div>
                                             <div style="margin-bottom: 10px;">
                                               <span style="color: #000000; margin-left: 30px;">Andorra - </span>
                                               <a href="tel:342999" style="color: #46735c; text-decoration: underline;">
                                                 342 999
                                               </a>
                                             </div>
                                             
                                                             </div>
                                                     <div style="margin-top: 25px;">
                                                       <img src="/img/cms/whatsapp.png" alt="" width="20" height="21" />
                                                       <span style="margin-top: 10px; color:#290000;"><strong>&nbsp&nbsp WhatsApp</strong></span><br>
                                                       <a href="https://api.whatsapp.com/send?phone=34674211874&amp;text=Quiero recibir m%C3%A1s%20informaci%C3%B3n" style="color: #46735c; text-decoration: underline; margin-left: 30px;">Contactar ahora</a>
                                                     </div>
                                                     <div style="margin-top: 25px;">
                                                       <img src="/img/cms/email.png" alt="" width="24" height="18" /> 
                                                       <span style="margin-top: 10px; color:#290000; margin-left: 10px;">
                                                         <strong>{l s='Send us an email' d='Shop.Theme.Customeraccount'}</strong>
                                                       </span>
                                                     </div>
                                                     <div style="margin-bottom: 10px;margin-top: 10px;">
                                                       <span style="color: #000000; margin-left: 30px;">Particulares - </span>
                                                       <a href="mailto:hola@disfrutaverdura.com" style="color: #46735c; text-decoration: underline;">
                                                         hola@disfrutaverdura.com
                                                       </a>
                                                     </div>
                                                     <div style="margin-bottom: 10px;">
                                                       <span style="color: #000000; margin-left: 30px;">Andorra - </span>
                                                       <a href="mailto:info@disfrutaverdura.ad" style="color: #46735c; text-decoration: underline;">
                                                         info@disfrutaverdura.ad
                                                       </a>
                                                     </div>
                                                     <div style="margin-bottom: 10px;">
                                                       <span style="color: #000000; margin-left: 30px;">Empresas - </span>
                                                       <a href="mailto:empresas@disfrutaverdura.com" style="color: #46735c; text-decoration: underline;">
                                                         empresas@disfrutaverdura.com
                                                       </a>
                                                     </div>

        <div style="margin-top: 25px;">
          <img src="/img/cms/form.png" alt="" width="24" height="18" /> 
          <span style="margin-top: 10px; color:#290000;"><strong>&nbsp&nbsp{l s='Complete the form' d='Shop.Theme.Customeraccount'}</strong></span><br>
                            {* <form action="/form-to-email.php" method="post" class="input-media-form" style="margin-top: 15px;">
                                

                                <input type="hidden" name="name" value="sad">
                                <input type="hidden" name="email" value="sdads@precognis.com">
                                <textarea name="message" placeholder="Dejanos tu mensaje" cols="50" rows="10"></textarea>
                    <br>
                                <input type="submit" name="enviar" class="btn btn-product-list" style="margin-top:30px;margin-bottom:30px;">

                            </form> *}
                        </br>
                            [contact-form-7 id="1"]
                            </div>

                        </div>
                    </div>

  
  </div>
            </section>

            {/block}


            