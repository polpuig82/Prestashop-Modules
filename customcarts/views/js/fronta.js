/**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2018 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 *
 * Don't forget to prefix your containers with your own identifier
 * to avoid any conflicts with others containers.
 */

$(document).ready(function() {
    $("input[name='city']").attr('id','locality');
    $("input[name='city']").attr('disabled','true');

    $("input[name='country']").attr('id','countryl');
    $("input[name='country']").attr('disabled','true');

    $("input[name='id_state']").attr('id','statel');
    $("input[name='id_state']").attr('disabled','true');


    $("input[name='slotname']").attr('id','slotname');
    $("input[name='slotname']").attr('disabled','true');

    $("input[name='deliveryslotid']").attr('id','deliveryslotid');

    $("input[name='slotday']").attr('id','slotday');

    $("input[name='address1']").attr('id','autocomplete');
    $("input[name='address1']").attr('onFocus','geolocate');



    //
    var unansweredBtn   = $("#slotname");

//-- Add our button.
    unansweredBtn.parent ().after (
        '<a class="btn btn-primary float-xs disabled" id="selectdelivery">Select Delivery</a>'
    );

//-- Activate the button.
    $("#selectdelivery").click ( function () {
        //rellenar dropdown
        //
        whoisCP(document.getElementsByName("postcode")[0].value,"update");
            select = document.getElementById('field-id_delivery_slot');
        $('#field-id_delivery_slot option:not(:first)').remove();

        if(carriersLunes>0)
            document.getElementById("diaLunes").classList.remove("disabled");
            if(carriersMartes>0)
                document.getElementById("diaMartes").classList.remove("disabled");
                if(carriersMiercoles>0)
                    document.getElementById("diaMiercoles").classList.remove("disabled");
                    if(carriersJueves>0)
                        document.getElementById("diaJueves").classList.remove("disabled");
                        if(carriersViernes>0)
                            document.getElementById("diaViernes").classList.remove("disabled");
                            if(carriersSabado>0)
                                document.getElementById(diaSabado).classList.remove("disabled");


        jQuery.each(carriersLunes, function(index, item){
            var opt = document.createElement('option');
            opt.value = index;
            opt.innerHTML = item.slotName;
            select.appendChild(opt);
        });
        rellenarDropdown();
        $('#myModalCarriers').modal();
    } );

    $('#myModalCarriers').on('hidden.bs.modal', function () {
        var diaT;
        switch($("input[name='dia']:checked").val()){
            case "Lunes":diaT=1;break;
            case "Martes":diaT=2;break;
            case "Miercoles":diaT=3;break;
            case "Jueves":diaT=4;break;
            case "Viernes":diaT=5;break;
            case "Sabado":diaT=6;break;
        }
        document.getElementById("slotday").value=diaT;
        document.getElementById("slotname").value=$("input[name='dia']:checked").val() +" "+$("#field-id_delivery_slot option:selected").text();
        document.getElementById("deliveryslotid").value=$("#field-id_delivery_slot").val();


    })


    /* pendiente cambio de código postal */
    if(document.getElementsByName("postcode").length>0)
    document.getElementsByName("postcode")[0].addEventListener('change',buscarDatos );

    /* pendiente seleccion dia */
    if (document.querySelector('input[name="dia"]')) {
        document.querySelectorAll('input[name="dia"]').forEach((elem) => {
            elem.addEventListener('change',rellenarDropdown );
        });
    }

    //Deshabilitar antes de submit
    if(document.getElementById("formAddress"))
    document.getElementById("formAddress").addEventListener('submit', functSubmit);
    function functSubmit() {
        $("input[name='city']").removeAttr('disabled');
        $("input[name='slotname']").removeAttr('disabled');
        $("input[name='id_state']").removeAttr('disabled');
        $("input[name='country']").removeAttr('disabled');
    }



    function rellenarDropdown()
    {
        select = document.getElementById('field-id_delivery_slot');
        $('#field-id_delivery_slot option:not(:first)').remove();
        var carriersSelect;
        switch(this.value){
            case "Lunes":carriersSelect=carriersLunes;break;
            case "Martes":carriersSelect=carriersMartes;break;
            case "Miercoles":carriersSelect=carriersMiercoles;break;
            case "Jueves":carriersSelect=carriersJueves;break;
            case "Viernes":carriersSelect=carriersViernes;break;
            case "Sabado":carriersSelect=carriersSabado;break;
            default: carriersSelect=carriersLunes;break;

        }


        jQuery.each(carriersSelect, function(index, item){
            var opt = document.createElement('option');
            opt.value = item.deliverySlotId;
            opt.innerHTML = item.slotName;
            select.appendChild(opt);
        });

    }
    /* function */
    function buscarDatos(){
        //alert('Horray! Someone wrote "' + this.value + '"!');
        //llamada a dame datos
         whoisCP(this.value);

    }

    $('#myModalCities').on('hidden.bs.modal', function () {
        indice=document.querySelector('input[name="id_location"]:checked').value;
        document.getElementById("locality").value=locations[indice].city;
        $("#field-id_state").val(locations[indice].region);
        $("#field-id_country").val(locations[indice].country);
        document.getElementById("selectdelivery").classList.remove("disabled");

    })



    function whoisCP(codPostal,state="normal")
    {
            $.ajax({
                type: "POST",
                url: urlCheckCP,
                data: { postalCode : codPostal},
                dataType: 'json',
                success: function (data){
                    var cuerpoModalCities="";
                    var cuerpoModalCarriers="";
                    jQuery.each(data, function(index, item) {
                        locations=data.locations;
                        carriers=data.deliverySlots;
                        carriersLunes=data.lunes;
                        carriersMartes=data.martes;
                        carriersMiercoles=data.miercoles;
                        carriersJueves=data.jueves;
                        carriersViernes=data.viernes;
                        carriersSabado=data.sabado;
                        if(index=="locations")
                        {
                            jQuery.each(data.locations, function(index2, item2) {
                                if(index2==0)
                                    checked="checked";
                                else
                                    checked="unchecked";
                                cuerpoModalCities+="<div class='col-12'></div><label class=\"radio-inline col-12\" for=\"field-id_gender-1\"> <span> <input name=\"id_location\" id=\"field-id_gender-1\" type=\"radio\" value='"+index2+"' "+checked+"> <span>"+item2.city+" </label></div>";
                            });
                        }

                    });
                    if(state=="normal") {
                        document.getElementById("cuerpoModalCities").innerHTML = cuerpoModalCities;
                        //Rellena Modal
                        $('#myModalCities').modal();
                    }
                },
                error : function(){
                    //aquí lo que se ejecuta en caso de que falle
                    alert("no");
                }
            })

    }



});




