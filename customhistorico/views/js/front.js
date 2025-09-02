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



function descargarFactura(idInvoice)
{
    $.ajax({
        url : urlFactura,
        data : {idInvoice:idInvoice},
        method : 'post', //en este caso
        responseType: "json",
        success : function(response){

            urlDescarga=urlInvoice+response;
            var link=document.createElement('a');
            link.setAttribute('target', '_blank');
            link.href=urlDescarga;
            link.click();

           /* var file = new Blob([response], {type: 'application/pdf'});
            var fileName = idInvoice+".pdf";
            var fileURL = window.URL.createObjectURL(file);
            var a = document.createElement("a");
            a.href = fileURL;
            a.download = fileName;
            a.click();*/

          /*  var binStr = response;
            var len = binStr.length;
            var arr = new Uint8Array(len);
            for (var i = 0; i < len; i++) {
                arr[ i ] = binStr.charCodeAt( i );
            }

            var blob = new Blob( [ arr ], { type: "application/pdf" } )
            var link=document.createElement('a');
            link.href=window.URL.createObjectURL(blob);
            link.download="factura.pdf";
            link.click();*/

        },
        error: function(error){
            //codigo error
        }
    });




}






