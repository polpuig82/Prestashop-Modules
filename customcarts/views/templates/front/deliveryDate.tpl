{*
* 2beweb2
*
*
* DISCLAIMER
*
* 2beweb2 and PrestaShop doesn't have any responsability in damage causate
* using this module
*
*  @author    2beweb2.com
*  @copyright 2beweb2
*  @license   Commercial
*}

<script>
    var codPostal;
    if(document.getElementsByName("postcode")[0].value)
        codPostal=document.getElementsByName("postcode")[0].value;


 
</script>

<div class="panel" >



    <!-- Bloque informativo (cuando existe una variable en la bbd)-->
    <div class="delivery-option">
        
        <h3>{l s='Time slot' mod='customaddress'}</h3>
        
        <div id="time-slot-selected">
            {if $slotname} 
                <p>{l s='Currently your time frame setting is' mod='customaddress'} {$slotname}<p>Si ya tienes una suscripción activa en esta dirección y deseas modificarla o cambiar el día en que realizamos tu entrega, por favor, envíanos un email a info@disfrutaverdura.com o llámanos al 915.643.145 / 93.241.42.10</p></p>

            {else} 
                <p>{l s='You have not yet configured your delivery time frame' mod='customaddress'}</p>
            {/if}
             

            <p> 
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" id="selectSlotButton">
                    {if $slotname} 
                        {l s='Change time slot' mod='customaddress'}
                    {else} 
                        {l s='Select new time slot' mod='customaddress'}
                    {/if} 
                </button>
            </p>


            
            <div class="collapse" id="collapseExample">
                <div class="card card-body">

                    <!-- Bloque selector -->
                    <div class="delivery-option"><h3>{l s='Select date delivery' mod='customaddress'}</h3>
                        <p>{l s='In weekly, fortnightly and monthly orders, your delivery will always be on the day and time you select' mod='customaddress'}</p>
                        <div class="row d-flex justify-content-center mt-100">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div>
                                            <input
                                                    type="radio"
                                                    class="option-input radio"
                                                    value="Lunes"
                                                    id="diaLunes"
                                                    name="dia"
                                            />
                                            <label>
                                                {l s='Monday' mod='customaddress'}
                                            </label>
                                        </div>
                                        <div>
                                            <input
                                                    type="radio"
                                                    class="option-input radio"
                                                    id="diaMartes"
                                                    value="Martes"
                                                    name="dia"
                                            />
                                            <label>
                                                {l s='Tuesday' mod='customaddress'}
                                            </label>
                                        </div>
                                        <div>
                                            <input
                                                    type="radio"
                                                    id="diaMiercoles"
                                                    value="Miercoles"
                                                    class="option-input radio"
                                                    name="dia"
                                            />
                                            <label>
                                                {l s='Wednesday' mod='customaddress'}
                                            </label>
                                        </div>
                                        <div>
                                            <input
                                                    type="radio"
                                                    id="diaJueves"
                                                    value="Jueves"
                                                    class="option-input radio"
                                                    name="dia"
                                            />
                                            <label>
                                                {l s='Thursday' mod='customaddress'}
                                            </label>
                                        </div>
                                        <div>
                                            <input
                                                    type="radio"
                                                    id="diaViernes"
                                                    value="Viernes"
                                                    class="option-input radio"
                                                    name="dia"
                                            />
                                            <label>
                                                {l s='Friday' mod='customaddress'}
                                            </label>
                                        </div>
                                        <div>
                                            <input
                                                    type="radio"
                                                    id="diaSabado"
                                                    value="Sabado"
                                                    class="option-input radio"
                                                    name="dia"
                                            />
                                            <label>
                                                {l s='Saturday' mod='customaddress'}
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 

                
                        <div id="time-slot-selector" class="form-group row">
                            <label
                                    class="col-md-3 form-control-label required"
                                    for="field-id_state"
                            >
                                {l s='Select the time slot' mod='customaddress'}
                            </label>
                            <div class="col-md-6">
                                <select
                                        id="field-id_delivery_slot"
                                        class="form-control form-control-select"
                                        name="id_delivery_slot"
                                >
                                    <option value="" disabled="" selected="">
                                        {l s='Select...' mod='customaddress'}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div> <!-- Fin del bloque selector-->

                </div> 
            </div>


        </div>
    </div> 
</div>
 