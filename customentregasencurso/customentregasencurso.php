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

include_once dirname(__FILE__) . '/classes/OrderInProgress.php';
include_once dirname(__FILE__) . '/classes/customOb.php';

class CustomEntregasEnCurso extends Module
{

    public function __construct()
    {
        $this->name = 'customentregasencurso';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Pol Puig';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => _PS_VERSION_,
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Custom Customer Deliveries in Progress Area D&V OpenBravo');
        $this->description = $this->l('Module for view Deliveries in Progress enjoy&vegetables.');
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
                'default_form_language' => (int) Configuration::get('PS_LANG_DEFAULT'),
            )
        );
        return $this->display(__FILE__, 'displayCustomerAccount.tpl');
    }

    public function hookDisplayHeader($params)
    {
        if (Tools::getValue('controller') == 'deliveriesinprogress') {
            $this->context->controller->addCSS($this->_path . 'views/css/front.css');
            $this->context->controller->addCSS($this->_path . 'views/css/animate.min.css');
            $this->context->controller->addCSS($this->_path . 'views/css/owl.carousel.min.css');
            $this->context->controller->addCSS($this->_path . 'views/css/owl.theme.default.min.css');

            $this->context->controller->addJS($this->_path . 'views/js/owl.carousel.min.js');
            $this->context->controller->addJS($this->_path . 'views/js/front-angy2.js');
            $this->context->controller->addJS($this->_path . 'views/js/app.js');
            $this->context->controller->addJS($this->_path . 'views/js/search.js');

            //url para enviar cambios

            if (empty($_SERVER['HTTPS'])) {
                $protocolo = 'http://';
            } else {
                $protocolo = 'https://';
            }
            $urlUpdate = $protocolo . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__ . "modules/customentregasencurso/enviarCambios.php";
            $urlDatoProducto = $protocolo . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__ . "modules/customentregasencurso/datosProducto.php";

            Media::addJsDef(array('urlAjaxControllerDeliveriesinprogress' => $this->context->link->getModuleLink($this->name, 'deliveriesinprogress')));
            Media::addJsDef(array('urlUpdate' => $urlUpdate, 'urlDatoProducto' => $urlDatoProducto));
          // Obtener el ID del grupo predeterminado del cliente
                $defaultGroupId = (int) $this->context->customer->id_default_group;

                // Inicializar valores
                $controlValue = 0;
                $margenAlternativo = 1.00; // por defecto, sin margen

                // Obtener cambiosdp
                $changesdp = Db::getInstance()->getValue(
                    'SELECT changesdp 
                    FROM ' . _DB_PREFIX_ . 'group 
                    WHERE id_group = ' . $defaultGroupId
                );

                if ($changesdp !== false && $changesdp > 0) {
                    $controlValue = (int) $changesdp;
                }

                // Obtener el margen alternativo (id_priceC)
                $id_priceC = Db::getInstance()->getValue(
                    'SELECT id_priceC 
                    FROM ' . _DB_PREFIX_ . 'group 
                    WHERE id_group = ' . $defaultGroupId
                );
                if ($id_priceC !== false && $id_priceC > 0) {
                    $margenAlternativo = (float) $id_priceC;
                }

                // Pasar configuración a Smarty y JS
                $this->context->smarty->assign('incremento_contenido_alternativo', $margenAlternativo);
                Media::addJsDef([
                    'control' => $controlValue,
                    'incrementoContenidoAlternativo' => $margenAlternativo,
                ]);


            $this->context->controller->removeJS('/modules/customaddress/views/js/front.js');
            $this->context->controller->removeJS('/themes/warehousechild/modules/customcarts/views/js/front-mini.js');
            $this->context->controller->removeCSS('/modules/customaddress/views/css/front.css');
            $this->context->controller->removeCSS('/modules/customcarts/views/css/front-mini.css');

        }
        // $this->context->controller->addJS($this->_path . 'views/js/front.js');
        // Media::addJsDef(array('iqitcountdown_days' => $this->l('d.')));
        // $this->context->controller->addJS($this->_path . 'views/js/front.js');
        // $this->context->controller->addJS(_PS_JS_DIR_.'jquery/jquery-3.5.1.min.js');
    }

    public function wsOBCall($params)
    {

        $url = "ws/com.precognis.externaldata.prestashop.disfrutayverdura.order";
        $login = Configuration::get('CONECTOROB_USERNAME_OB');
        $password = Configuration::get('CONECTOROB_PASSWORD_OB');
        $url = Configuration::get('CONECTOROB_URLOB') . $url;
        $id_lang = Context::getContext()->language->id;
        $query = http_build_query($params);
        $ch = curl_init();
        $arraypedidosencuso = array();

        curl_setopt($ch, CURLOPT_URL, "$url?$query");
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        // print_r($result);

        if (curl_errno($ch)) {
            echo curl_error($ch);
            curl_close($ch);
            return null;
        } else {
            if (CustomEntregasEnCurso::isJson($result)) {
                //  $decoded = json_decode($result);
                //   $decoded = json_decode($result, true);
                $data = json_decode($result, true);
                $datas = $data['data'];
                foreach ($datas as $dat) {
                    $OrderinProgress = new orderInProgress();
                    $OrderinProgress->deliveryId = $dat['deliveryId'];
                    $OrderinProgress->obId = $dat['obId'];
                    $OrderinProgress->clientId = $dat['clientId'];
                    $OrderinProgress->shippingAddressId = $dat['shippingAddressId'];
                    //$OrderinProgress->shippingAddressId=43; //Para probar
                    $OrderinProgress->shippingAddress = new Address($OrderinProgress->shippingAddressId);
                    $OrderinProgress->billingAddressId = $dat['billingAddressId'];
                    $OrderinProgress->status = $dat['status'];
                    $OrderinProgress->orderDate = $dat['orderDate'];
                    $OrderinProgress->shippingDate = $dat['shippingDate'];
                    $OrderinProgress->deliverySlotId = $dat['deliverySlotId'];
                    $OrderinProgress->slotName = $dat['slotName'];
                    $OrderinProgress->totalAmount = $dat['totalAmount'];
                    $OrderinProgress->invoiceId = $dat['invoiceId'];
                    $OrderinProgress->invoiceNo = $dat['invoiceNo'];
                    
                    //limpiar string
                    $OrderinProgress->order = array();
                    //Preparando order
                    foreach ($dat['order'] as $p) {
                        $pr = CustomOb::getProducto($p, $id_lang);
                        // $pr2 = CustomOb::setPedidosEnCurso($OrderinProgress);
                        $pr['content'] = CustomOb::getProductosContent($p['content'], $id_lang);
                        $pr['alternativos'] = CustomOb::getProductosAlternativos($p['alternative'], $id_lang);
                        unset($pr['alternative']);
                        array_push($OrderinProgress->order, $pr);
                    }

                    //  Array ( [0] => Array ( [productId] => 65 [lineId] => 10 [frecuencyId] => 27 [quantity] => 1 [grossUnitPrice] => 23.75 [orderPlanId] => B350759C87464617912A0D872EED09DA [content] => Array ( [0] => Array ( [productId] => 66 [changeAllowed] => 1 ) [1] => Array ( [productId] => 70 [changeAllowed] => 1 ) [2] => Array ( [productId] => 49 [changeAllowed] => 1 ) [3] => Array ( [productId] => 57 [changeAllowed] => 1 ) ) [extras] => Array ( ) [alternative] => Array ( [0] => 72 [1] => 68 [2] => 64 [3] => 71 [4] => 47 [5] => 67 [6] => 63 [7] => 69 [8] => 54 ) ) )

                    array_push($arraypedidosencuso, $OrderinProgress);

                }

                $result = $arraypedidosencuso;

                curl_close($ch);
                return $result;
            } else {

                $result = utf8_encode($result);
                $result = strip_tags($result);
                curl_close($ch);
                return json_encode(array('error' => $result), JSON_UNESCAPED_UNICODE);
            }

        }

    }


    public function wsOBCallCashBack($params)
    {

        $url="/ws/com.precognis.externaldata.prestashop.disfrutayverdura.cashback";
        $login=Configuration::get('CONECTOROB_USERNAME_OB');
        $password=Configuration::get('CONECTOROB_PASSWORD_OB');
        $url=Configuration::get('CONECTOROB_URLOB').$url;
        $id_lang = Context::getContext()->language->id;
        $query=http_build_query($params);
        $ch = curl_init();
        $arrayCashback=Array();

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
            if (CustomEntregasEnCurso::isJson($result)) {
                $data = json_decode($result, true);
            
                // Crear un nuevo array asociativo para almacenar los valores
                $resultArray = [];
            
                // Agregar los valores al nuevo array
                $resultArray['balance'] = $data['balance'];
                $resultArray['lastMovement'] = $data['lastmovement'];
                $resultArray['expirationDate'] = $data['expirationDate'];
                $resultArray['maxPercentage'] = $data['maxPercentage'];
                $resultArray['cashbackProduct'] = $data['cashbackProduct'];
                if (isset($data['transaciones'])) {
                    $resultArray['transaciones'] = $data['transaciones'];
                } else {
                    $resultArray['transaciones'] = 'N/A';
                }            
                curl_close($ch);
                return $resultArray;
            }
            
           
            
        else
        {
            
            $result=utf8_encode($result);
            $result=strip_tags($result);
            curl_close($ch);
            return array('error' => $result);
        }

    }

    }

    public function modifyOrder($datosPedido, $obId)
    {
        //hacer llamada para traer todos los otros datos
        $id_customer = $this->context->customer->id;
        $params = array("clientId" => $id_customer, "encurso" => 1);
        $result = $this->wsOBCall($params);
        $contenidoaCambiar = new orderInProgress();
        foreach ($result as $dat) {
            $oip = new orderInProgress();
            $oip = $dat;
            if ($oip->obId == $obId) {
                $contenidoaCambiar = $dat;
                break;
            }

        }

        //
        $putProducts = array();
        foreach ($datosPedido as $dato) {
            $nodo = array();
            if (!isset($dato['lista'])) {
                $nodo['productId'] = $dato['id'];
                $nodo['quantity'] = $dato['quantity'];
                $nodo['grossUnitPrice'] = $dato['grossUnitPrice'];
                if ($dato['orderPlanId'] != "") {
                    $nodo['orderPlanId'] = $dato['orderPlanId'];
                } else {
                    $nodo['orderPlanId'] = null;
                }

                $nodo['content'] = [];
                $nodo['extras'] = [];
                $nodo['frecuencyId'] = "";
                $nodo['lineId'] = 0;
                array_push($putProducts, $nodo);
            } else {
                $nodo['productId'] = $dato['id'];
                $nodo['quantity'] = $dato['quantity'];
                $nodo['grossUnitPrice'] = $dato['grossUnitPrice'];
                if ($dato['orderPlanId'] != "") {
                    $nodo['orderPlanId'] = $dato['orderPlanId'];
                } else {
                    $nodo['orderPlanId'] = null;
                }

                $content = array();
                foreach ($dato['lista'] as $comp) {
                    $ncont['productId'] = $comp['id'];
                    //  $ncont['changeAllowed']=$comp['changeAllowed'];
                    array_push($content, $ncont);
                }
                $nodo['content'] = $content;
                $nodo['extras'] = [];
                $nodo['alternative'] = "[]";
                $nodo['frecuencyId'] = "";
                $nodo['lineId'] = 0;

                array_push($putProducts, $nodo);
            }
        }
        $estructuraFinal = array();
        $estructuraFinal['deliveryId'] = $contenidoaCambiar->deliveryId;
        $estructuraFinal['obId'] = $contenidoaCambiar->obId;
        $estructuraFinal['clientId'] = $contenidoaCambiar->clientId;
        $estructuraFinal['orderDate'] = $contenidoaCambiar->orderDate;
        $estructuraFinal['order'] = $putProducts;

        $payload = json_encode($estructuraFinal);

        $url = "ws/com.precognis.externaldata.prestashop.disfrutayverdura.order";
        $login = Configuration::get('CONECTOROB_USERNAME_OB');
        $password = Configuration::get('CONECTOROB_PASSWORD_OB');
        $url = Configuration::get('CONECTOROB_URLOB') . $url;
        $id_lang = Context::getContext()->language->id;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return curl_error($ch);
        } else {
            curl_close($ch);
            return $result;
        }

    }


    public function modifyOrderShoppingCart($datosPedido, $obId)
    {

        //hacer llamada para traer todos los otros datos
        $id_customer = $this->context->customer->id;
        $params = array("clientId" => $id_customer, "encurso" => 1);
        $result = $this->wsOBCall($params);
        $contenidoaCambiar = new orderInProgress();
        foreach ($result as $dat) {
            $oip = new orderInProgress();
            $oip = $dat;
            if ($oip->obId == $obId) {
                $contenidoaCambiar = $dat;
                break;
            }

        }

        //
        $putProducts = array();
        foreach ($datosPedido as $dato) {

            $nodo = array();
                $nodo['productId'] = $dato['id'];
                $nodo['quantity'] = $dato['quantity'];
                $nodo['grossUnitPrice'] = $dato['grossUnitPrice'];
                if ($dato['orderPlanId'] != "") {
                    $nodo['orderPlanId'] = $dato['orderPlanId'];
                } else {
                    $nodo['orderPlanId'] = null;
                }

               

                $nodo['content'] = $dato['content'];
                $nodo['extras'] = $dato['extras'];
                $nodo['frecuencyId'] = "";
                $nodo['lineId'] = 0;
                array_push($putProducts, $nodo);
            
        }
        $estructuraFinal = array();
        $estructuraFinal['deliveryId'] = $contenidoaCambiar->deliveryId;
        $estructuraFinal['obId'] = $contenidoaCambiar->obId;
        $estructuraFinal['clientId'] = $contenidoaCambiar->clientId;
        $estructuraFinal['orderDate'] = $contenidoaCambiar->orderDate;
        $estructuraFinal['order'] = $putProducts;
       

        $payload = json_encode($estructuraFinal);

        $url = "ws/com.precognis.externaldata.prestashop.disfrutayverdura.order";
        $login = Configuration::get('CONECTOROB_USERNAME_OB');
        $password = Configuration::get('CONECTOROB_PASSWORD_OB');
        $url = Configuration::get('CONECTOROB_URLOB') . $url;
        $id_lang = Context::getContext()->language->id;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return curl_error($ch);
        } else {
            curl_close($ch);
            return $result;
        }

    }

    public function isJson($string)
    {return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false;}

    public function datoProducto($idProduct)
    {
        $id_lang = Context::getContext()->language->id;
        $result['productId'] = $idProduct;
        return CustomOb::getProducto($result, $id_lang);

/*return $result;*/

    }

}
