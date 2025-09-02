<?php
/**
 * 2007-2022 PrestaShop
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2022 PrestaShop SA
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

include_once dirname(__FILE__) . '/classes/orderHistory.php';
//include_once dirname(__FILE__) . '/classes/customObSuscripciones.php';

class CustomHistorico extends Module
{


    public function __construct()
    {
        $this->name = 'customhistorico';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Francisco Martínez Vico, Precognis';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => _PS_VERSION_,
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Custom Customer History in Progress Area D&V OpenBravo');
        $this->description = $this->l('Module for view History in Progress enjoy&vegetables.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

    }

    public function install()
    {
        $result = true;
        if (!parent::install()
            || !$this->registerHook('displayCustomerAccount')
          //  || !$this->registerHook('actionCustomerAddressGridDefinitionModifier')
          //  || !$this->registerHook('actionCustomerAddressGridQueryBuilderModifier')
          //  || !$this->registerHook('displaySelectCity')
          //  || !$this->registerHook('displaySelectDeliveryDate')
          //  || !$this->registerHook('displayBeforeCarrier')
            || !$this->registerHook('displayHeader')
        ) {
            $result = false;
        }




        return $result;

    }





    public function uninstall()
    {
        if (!parent::uninstall()
        ) {
            return false;
        }

        return true;
    }


    public function hookDisplayCustomerAccount($params)
    {
        $this->context->smarty->assign(
            array(
                'id_customer' => $this->context->customer->id,
                'default_form_language' => (int)Configuration::get('PS_LANG_DEFAULT')
            )
        );
        return $this->display(__FILE__, 'displayCustomerAccount.tpl');
    }





    public function hookDisplayHeader($params)
    {
        if (Tools::getValue('controller') == 'historico') {
            $this->context->controller->addCSS($this->_path . 'views/css/front.css');



                $this->context->controller->addJS($this->_path . 'views/js/front.js');


            //url para enviar cambios

            if (empty($_SERVER['HTTPS'])) {
                $protocolo = 'http://';
            } else {
                $protocolo = 'https://';
            }
            $urlFactura   = $protocolo . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__ . "modules/customhistorico/invoice.php";
            $urlDatoProducto   = $protocolo . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__ . "modules/customhistorico/datosProducto.php";
            $urlInvoice   = $protocolo . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__ . "modules/customhistorico/tmp/";

             Media::addJsDef(array('urlFactura' => $urlFactura,'urlDatoProducto' => $urlDatoProducto,'urlInvoice' => $urlInvoice));
        }
       // $this->context->controller->addJS($this->_path . 'views/js/front.js');
        // Media::addJsDef(array('iqitcountdown_days' => $this->l('d.')));
        // $this->context->controller->addJS($this->_path . 'views/js/front.js');
        // $this->context->controller->addJS(_PS_JS_DIR_.'jquery/jquery-3.5.1.min.js');
    }

    public function wsOBCall($params)
    {

        $url="ws/com.precognis.externaldata.prestashop.disfrutayverdura.order";
        $login=Configuration::get('CONECTOROB_USERNAME_OB');
        $password=Configuration::get('CONECTOROB_PASSWORD_OB');
        $url=Configuration::get('CONECTOROB_URLOB').$url;
        $id_lang = Context::getContext()->language->id;
        $query=http_build_query($params);
        $ch = curl_init();
        $arrayHistorico=Array();

        curl_setopt($ch, CURLOPT_URL, "$url?$query" );
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);



        if (curl_errno($ch)) {
            echo curl_error($ch);
            curl_close($ch);
            return null;
        }



        else {
            if(CustomEntregasEnCurso::isJson($result)){
                //  $decoded = json_decode($result);
                //   $decoded = json_decode($result, true);
                $data = json_decode($result,true);
                $datas=$data['data'];
                foreach ($datas as $dat)
                {
                    $OrderHistory= new orderHistory();
                    $OrderHistory->deliveryId=$dat['deliveryId'];
                    $OrderHistory->obId=$dat['obId'];
                    $OrderHistory->clientId=$dat['clientId'];
                    $OrderHistory->shippingAddressId=$dat['shippingAddressId'];
                  //  $OrderHistory->shippingAddressId=43; //Para probar
                    $OrderHistory->shippingAddress= new Address($OrderHistory->shippingAddressId);
                    $OrderHistory->billingAddressId=$dat['billingAddressId'];
                    $OrderHistory->status=$dat['status'];
                    $OrderHistory->orderDate=$dat['orderDate'];
                    $OrderHistory->shippingDate=$dat['shippingDate'];
                    $OrderHistory->deliverySlotId=$dat['deliverySlotId'];
                    $OrderHistory->slotName=$dat['slotName'];
                    $OrderHistory->totalAmount=$dat['totalAmount'];
                    $OrderHistory->invoiceId=$dat['invoiceId'];
                    $OrderHistory->invoiceNo=$dat['invoiceNo'];
                    //limpiar string
                    $OrderHistory->order=array();
                    //Preparando order
                    foreach ($dat['order'] as $p)
                    {
                        $pr=CustomOb::getProducto($p,$id_lang);
                        $pr['content']=CustomOb::getProductosContent($p['content'],$id_lang);
                        array_push($OrderHistory->order,$pr);
                    }



                    //  Array ( [0] => Array ( [productId] => 65 [lineId] => 10 [frecuencyId] => 27 [quantity] => 1 [grossUnitPrice] => 23.75 [orderPlanId] => B350759C87464617912A0D872EED09DA [content] => Array ( [0] => Array ( [productId] => 66 [changeAllowed] => 1 ) [1] => Array ( [productId] => 70 [changeAllowed] => 1 ) [2] => Array ( [productId] => 49 [changeAllowed] => 1 ) [3] => Array ( [productId] => 57 [changeAllowed] => 1 ) ) [extras] => Array ( ) [alternative] => Array ( [0] => 72 [1] => 68 [2] => 64 [3] => 71 [4] => 47 [5] => 67 [6] => 63 [7] => 69 [8] => 54 ) ) )

                    array_push($arrayHistorico,$OrderHistory);




                }

                $result=$arrayHistorico;


                curl_close($ch);
                return $result;
        }
        else
        {
            
            $result=utf8_encode($result);
            $result=strip_tags($result);
            curl_close($ch);
            return json_encode(array('error' => $result),JSON_UNESCAPED_UNICODE);
        }

    }






    }




    public function isJson($string)

    { return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false; }


    public function datoProducto($idProduct)
    {
        $id_lang = Context::getContext()->language->id;
        $result['productId'] = $idProduct;
        return CustomOb::getProducto($result, $id_lang);

        return $result;


    }

    public function invoicePDF($idInvoice)
    {

        $url = "ws/com.peoplewalking.disfrutayverdura.magento.invoicepdf";
        $params = array("invoiceId" => $idInvoice);
        $login = Configuration::get('CONECTOROB_USERNAME_OB');
        $password = Configuration::get('CONECTOROB_PASSWORD_OB');
        $url = Configuration::get('CONECTOROB_URLOB') . $url;
        $id_lang = Context::getContext()->language->id;
        $query = http_build_query($params);
        $ch = curl_init();


        curl_setopt($ch, CURLOPT_URL, "$url?$query");
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);


        if (curl_errno($ch)) {
            echo curl_error($ch);
            curl_close($ch);
            return null;
        } else {


                curl_close($ch);
                return $result;


        }


    }


}

