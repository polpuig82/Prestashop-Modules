
<!-- Example Modal, make the required changes -->
<div id="myModalCarriers" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{l s='Select Delivery' mod='customaddress'}</h4>
            </div>
            <div class="modal-body" id="cuerpoModalCarriers">

                <div class="row d-flex justify-content-center mt-100">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div> <label> <input type="radio" class="option-input radio disabled" value="Lunes" id="diaLunes" name="dia" checked /> {l s='Monday' mod='customaddress'} </label> <label> <input type="radio" class="option-input radio disabled" id="diaMartes" value="Martes" name="dia" /> {l s='Tuesday' mod='customaddress'} </label> <label> <input type="radio" id="diaMiercoles" value="Miercoles" class="option-input radio disabled" name="dia" /> {l s='Wednesday' mod='customaddress'} </label> <label> <input type="radio"  id="diaJueves" value="Jueves" class="option-input radio disabled" name="dia" /> {l s='Thursday' mod='customaddress'} </label> <label> <input type="radio" id="diaViernes" value="Viernes" class="option-input radio disabled" name="dia" /> {l s='Friday' mod='customaddress'} </label> <label> <input type="radio"  id="diaSabado" value="Sabado" class="option-input radio disabled" name="dia" /> {l s='Saturday' mod='customaddress'} </label> </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group row ">
                    <label class="col-md-3 form-control-label required" for="field-id_state">
                        {l s='Select the time slot' mod='customaddress'}
                    </label>
                    <div class="col-md-6">



                        <select id="field-id_delivery_slot" class="form-control form-control-select" name="id_delivery_slot">
                            <option value="" disabled="" selected="">{l s='Select...' mod='customaddress'}</option>
                        </select>






                    </div>


                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{l s='Select' mod='customcarts'}</button>
            </div>
        </div>

    </div>
</div>