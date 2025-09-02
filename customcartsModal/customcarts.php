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
use PrestaShop\PrestaShop\Adapter\MailTemplate\MailPartialTemplateRenderer;
if (!defined('_PS_VERSION_')) {
    exit;
}

include_once dirname(__FILE__) . '/classes/customCartsOb.php';

include_once dirname(__FILE__) . '/classes/customCartsOrder.php';

include_once dirname(__FILE__) . '/classes/customCartsCart.php';

class CustomCarts extends Module
{
    /** @var MailPartialTemplateRenderer|null */
    protected $partialRenderer;

    public function __construct()
    {
        $this->name = 'customcarts';
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

        $this->displayName = $this->l('Custom Carts D&V');
        $this->description = $this->l('Module for cart customization enjoy&vegetables.');
        $this->configure     = true;
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        if (!parent::install()) {
            return false;
        }

        Configuration::updateValue('CUSTOMCARTS_PARAMETROCONTROL', '6');

        // install DataBase
        if (!$this->installSQL()) {
            return false;
        }

        return ($this->registerHook('displayCestaPersonalizada')
            && $this->registerHook('addWebserviceResources')
            && $this->registerHook('displayCestaPersonalizadaCart')
            && $this->registerHook('displayCestaPersonalizadaOrder')
            && $this->registerHook('displayCestaPersonalizadaMyAccount')
            && $this->registerHook('actionObjectProductInCartDeleteAfter')
            && $this->registerHook('actionValidateOrder')
            && $this->registerHook('actionCartUpdateQuantityBefore')
            && $this->registerHook('sendMailAlterTemplateVars')
            && $this->registerHook('displayHeader'));
    }

    public function uninstall()
    {
        if (!$this->uninstallSQL()) {
            return false;
        }


     /*   if (!parent::uninstall() ||
            !$this->unregisterHook('displayCestaPersonalizada')
            || !$this->unregisterHook('addWebserviceResources')
            || !$this->unregisterHook('displayCestaPersonalizadaCart')) {
            return false;
        }*/
        return true;
    }


    public function getContent()
    {
        $output = null;
        $errors = array();
     //   $cabecera = $this->display(__FILE__, 'views/templates/admin/config.tpl');
      //  return  $cabecera . $this->displayForm();
        if (Tools::isSubmit('submit' . $this->name)) {
            $parametro = Tools::getValue('CUSTOMCARTS_PARAMETROCONTROL');
            Configuration::updateValue('CUSTOMCARTS_PARAMETROCONTROL', $parametro);
            if (!Configuration::updateValue('CUSTOMCARTS_PARAMETROCONTROL', $parametro)) {
                $errors[] = $this->trans('It has not been updated correctly');
            }
            $output .= $this->displayConfirmation($this->l('Update done successfully'));
        }


        if (empty($_SERVER['HTTPS'])) {
            $protocolo = 'http://';
        } else {
            $protocolo = 'https://';
        }
        $urltienda = $protocolo . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__ . "modules/customcarts/";
        $this->context->smarty->assign(array(
            'urltienda' => $urltienda,
        ));
        $cabecera = $this->display(__FILE__, 'views/templates/admin/config.tpl');
        return $output . $this->displayForm();

    }

    public function displayForm()
    {
        $default_lang=$this->context->language->id;

        $fields_form            = array();
        $fields_form[0]['form'] = array(
            'legend'  => array(
                'title' => $this->l('Settings'),
            ),
            'input'   => array(
                array(
                    'type'  => 'text',
                    'label' => $this->l('Limit Changes Cart'),
                    'name'  => 'CUSTOMCARTS_PARAMETROCONTROL',
                    'desc'  => $this->l('Parameters controls Custom Carts'),
                ),

            ), // --- end of input
            'buttons' => array(
                'cancelBlock' => array(
                    'title' => $this->l('Cancel'),
                    'href'  => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                    'icon'  => 'process-icon-cancel',
                ),
            ),
            'submit'  => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right',
            ),
        );

        $helper = new HelperForm();
// Module, token and currentIndex
        $helper->module          = $this;
        $helper->name_controller = $this->name;
        $helper->token           = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex    = AdminController::$currentIndex . '&configure=' . $this->name;
// Language
        $helper->default_form_language    = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;
// Title and toolbar
        $helper->title          = $this->displayName;
        $helper->show_toolbar   = true; // false -> remove toolbar
        $helper->toolbar_scroll = true; // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action  = 'submit' . $this->name;
        $helper->toolbar_btn    = array(
            'save' => array(
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name .
                    '&token=' . Tools::getAdminTokenLite('AdminModules'),
            ),
            'back' => array(
                'href' => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Cancel'),
            ),
        );

// Load current value
        $helper->fields_value['CUSTOMCARTS_PARAMETROCONTROL']    = Configuration::get('CUSTOMCARTS_PARAMETROCONTROL');
        return $helper->generateForm($fields_form);
    }

    public function hookDisplayHeader($params)
    {
       
        $this->context->controller->addCSS($this->_path . 'views/css/front.css');
         $this->context->controller->addJS($this->_path . 'views/js/front.js');
       // Media::addJsDef(array('iqitcountdown_days' => $this->l('d.')));
       // $this->context->controller->addJS($this->_path . 'views/js/front.js');
       // $this->context->controller->addJS(_PS_JS_DIR_.'jquery/jquery-3.5.1.min.js');
    }

    public function hookActionObjectProductInCartDeleteAfter($params)
    {
       $id_cart=$params['id_cart'];
       $id_product=$params['id_product'];
        $product_attribute_id=$params['id_product_attribute'];
        $pr=customCartsCart::exisProductCart($id_cart,$id_product,$product_attribute_id);
        if(!empty($pr))
       customCartsCart::deleteProductCart($id_cart,$id_product,$product_attribute_id);


    }

    public function hookActionCartUpdateQuantityBefore($params)
    {

        $id_cart=$params['cart']->id;
        $id_product=$params['product']->id;
        $product_attribute_id=$params['id_product_attribute'];
        $pr=customCartsCart::exisProductCart($id_cart,$id_product,$product_attribute_id);
        if(!empty($pr)) {
           //eliminar producto del carrito;
            //$this->context->cart->deleteProduct($id_product,$product_attribute_id);
            if(Tools::getValue('ElementoCestaInp1')!= Null) {
                $this->context->cart->deleteProduct($id_product,$product_attribute_id);
                customCartsCart::deleteProductCart($id_cart, $id_product, $product_attribute_id);

            }
        }
            $id_lang = Context::getContext()->language->id;
            //Añadir a table cart foreach de lo que me viene como gettools json


            //Sacar cuantos elementos tiene este producto

            $numElementos = customCartsOb::getNumProductosCestaDefinida($id_product, $id_lang);


            if (count($numElementos) > 0) {

                for ($i = 1; $i <= count($numElementos); $i++) {
                    $componente = Tools::getValue('ElementoCestaInp' . $i);
                    $elemento = customCartsOb::getProductoCestaDefinida($id_product, $componente, $id_lang);
                    if($componente!=0)
                    customCartsCart::insertProductCart($id_cart, $id_product, $product_attribute_id,$elemento['componente'], $elemento['alternativo'], $elemento['intercambiable'], $elemento['name']);
                }
            }





    }



    public function hookDisplayCestaPersonalizada($params)
    {
        $id_product=$params['product']['id'];

        $id_cart=$this->context->cart->id;

        $id_lang = $this->context->language->id;

        $productosCestaDefinida=customCartsOb::getProductosCestaDefinida($id_product,$id_lang);
        $productosCestaAlternativa=customCartsOb::getProductosCestaAlternativa($id_product,$id_lang);


        if(count($productosCestaDefinida)>0) {
            $this->context->smarty->assign(array(
                'productosCestaDefinida' => $productosCestaDefinida,
                'productosCestaAlternativa' => $productosCestaAlternativa,
                'control'=>Configuration::get('CUSTOMCARTS_PARAMETROCONTROL'),
            ));
            return $this->display(__FILE__, 'views/templates/front/product.tpl');
        }
    }


    public function hookDisplayCestaPersonalizadaMyAccount($params)
    {
        $id_product=$params['product']['id_product'];

        $product_attribute_id=$params['product']['id_product_attribute'];

        $id_order_detail=$params['product']['id_order_detail'];

        $detail= New OrderDetail($id_order_detail);

        $id_order=$detail->id_order;



        $id_lang = $this->context->language->id;

        $productosCestaDefinida=customCartsOb::getProductosCestaDefinida($id_product,$id_lang);
        $productosCestaAlternativa=customCartsOb::getProductosCestaAlternativa($id_product,$id_lang);
        $productosCestaOrder=customCartsOrder::getProductsOrder($id_order,$id_product,$product_attribute_id);

        if (empty($_SERVER['HTTPS'])) {
            $protocolo = 'http://';
        } else {
            $protocolo = 'https://';
        }
        $urlUpdate   = $protocolo . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__ . "modules/customcarts/modifyBasketMyAccount.php";

        if(count($productosCestaDefinida)>0) {
            $this->context->smarty->assign(array(
                'productosCestaDefinida' => $productosCestaDefinida,
                'productosCestaAlternativa' => $productosCestaAlternativa,
                'productosCestaOrder' => $productosCestaOrder,
                'control'=>Configuration::get('CUSTOMCARTS_PARAMETROCONTROL'),
                'id_order' => $id_order,
                'id_product' => $id_product,
                'product_attribute_id' => $product_attribute_id,
            ));
            return $this->display(__FILE__, 'views/templates/front/productMyAccount.tpl');
        }
    }

    public function hookDisplayCestaPersonalizadaCart($params)
    {
        $id_product=$params['product']['id'];

        $product_attribute_id=$params['product']['id_product_attribute'];

        $id_cart=$this->context->cart->id;


        $productosCesta=customCartsCart::getProductCart($id_cart,$id_product,$product_attribute_id);

        if(count($productosCesta)>0) {
            $this->context->smarty->assign(array(
                'productosCesta' => $productosCesta,
            ));
            return $this->display(__FILE__, 'views/templates/front/product_line.tpl');
        }
    }

     public function hookDisplayCestaPersonalizadaOrder($params)
    {
        $id_product=$params['product']['id_product'];

        $product_attribute_id=$params['product']['id_product_attribute'];

        //$id_order=$this->context->order->id;

        $id_order=Tools::getValue('id_order');

        $id_lang = $this->context->language->id;

        $productosCesta=customCartsOrder::getProductOrder($id_order,$id_product,$product_attribute_id);

        if(count($productosCesta)>0) {
            $this->context->smarty->assign(array(
                'productosCesta' => $productosCesta,
            ));
            return $this->display(__FILE__, 'views/templates/front/product_line.tpl');
        }
    }

    public function modifyBasketMyAccount($id_order,$data)
    {

    }



    /*public function hookActionEmailSendBefore($params) {

        if($params["template"] == "order_conf") { # or bankwire or ,.....
            if (is_array($params['bcc']))
            {
                $params['bcc'][] = "duummmmyyy@gmail.com";
            }
            else
            {
                $params['bcc'] = ["duummmmyyy@gmail.com"];
            }
        }
    }*/

    public function hookSendMailAlterTemplateVars($params)
    {
        $id_lang = $this->context->language->id;


        if (!isset($params['template']) && !isset($params['{products}'])) {
            return;
        }

        //$params['template'] == 'payment' ||
        if ($params['template'] == 'order_conf') {
            if ($params['template_vars']['{order_name}']) {
                $reference = $params['template_vars']['{order_name}'];
                $sql = 'SELECT * FROM ' . _DB_PREFIX_ . 'orders WHERE reference = "' . $reference . '" Limit 1 ';
                $orderRow = Db::getInstance()->executeS($sql);
                $virtual_product = true;
                if (!empty($orderRow)) {
                    $id_order = reset($orderRow)['id_order'];
                    $order = new Order ($id_order);
                    $order->product_list = $order->getCartProducts();
                    $product_var_tpl_list= Array();
                    foreach ($order->product_list as $product) {
                        $price = Product::getPriceStatic((int)$product['id_product'], false, ($product['id_product_attribute'] ? (int)$product['id_product_attribute'] : null), 6, null, false, true, $product['product_quantity'], false, (int)$order->id_customer, (int)$order->id_cart, (int)$order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}, $specific_price, true, true, null, true, $product['id_customization']);
                        $price_wt = Product::getPriceStatic((int)$product['id_product'], true, ($product['id_product_attribute'] ? (int)$product['id_product_attribute'] : null), 2, null, false, true, $product['product_quantity'], false, (int)$order->id_customer, (int)$order->id_cart, (int)$order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}, $specific_price, true, true, null, true, $product['id_customization']);

                        $product_price = Product::getTaxCalculationMethod() == PS_TAX_EXC ? Tools::ps_round($price, Context::getContext()->getComputingPrecision()) : $price_wt;

                        //nombre Producto en su idioma:

                    //    $p = new Product((int)$product['id_product'], false, $id_lang);

                    //   $nombreProducto=$p->name . (isset($product['attributes']) ? ' - ' . $product['attributes'] : '');
                        $nombreProducto=$product['product_name'];

                        $product_var_tpl = [
                            'id_product' => $product['id_product'],
                            'id_product_attribute' => $product['id_product_attribute'],
                            'reference' => $product['reference'],
                            'name' => $nombreProducto,
                            'price' => Tools::getContextLocale($this->context)->formatPrice($product_price * $product['product_quantity'], $this->context->currency->iso_code),
                            'quantity' => $product['product_quantity'],
                            'customization' => [],
                        ];

                        if (isset($product['price']) && $product['price']) {
                            $product_var_tpl['unit_price'] = Tools::getContextLocale($this->context)->formatPrice($product_price, $this->context->currency->iso_code);
                            $product_var_tpl['unit_price_full'] = Tools::getContextLocale($this->context)->formatPrice($product_price, $this->context->currency->iso_code)
                                . ' ' . $product['unity'];
                        } else {
                            $product_var_tpl['unit_price'] = $product_var_tpl['unit_price_full'] = '';
                        }

                        $customized_datas = Product::getAllCustomizedDatas((int)$order->id_cart, null, true, null, (int)$product['id_customization']);
                        if (isset($customized_datas[$product['id_product']][$product['id_product_attribute']])) {
                            $product_var_tpl['customization'] = [];
                            foreach ($customized_datas[$product['id_product']][$product['id_product_attribute']][$order->id_address_delivery] as $customization) {
                                $customization_text = '';
                                if (isset($customization['datas'][Product::CUSTOMIZE_TEXTFIELD])) {
                                    foreach ($customization['datas'][Product::CUSTOMIZE_TEXTFIELD] as $text) {
                                        $customization_text .= '<strong>' . $text['name'] . '</strong>: ' . $text['value'] . '<br />';
                                    }
                                }

                                if (isset($customization['datas'][Product::CUSTOMIZE_FILE])) {
                                    $customization_text .= $this->trans('%d image(s)', [count($customization['datas'][Product::CUSTOMIZE_FILE])], 'Admin.Payment.Notification') . '<br />';
                                }

                                $customization_quantity = (int)$customization['quantity'];

                                $product_var_tpl['customization'][] = [
                                    'customization_text' => $customization_text,
                                    'customization_quantity' => $customization_quantity,
                                    'quantity' => Tools::getContextLocale($this->context)->formatPrice($customization_quantity * $product_price, $this->context->currency->iso_code),
                                ];
                            }
                        }

                        //Sacar Nombre para meter en correo
                        $productosCesta=customCartsOrder::getProductsOrder($id_order,$id_lang,$product['id_product']);
                        if(count($productosCesta)>0)
                        {

                            $contador=1;
                            $nombreProducto="";

                            foreach ($productosCesta as $pr)
                            {

                                $nombreProducto .= " (*) "  . $pr['name'];
                                $contador++;
                               // $nombreProducto.=''. $pr['name'] . ',';
                            }
                            //$nombreProducto=substr($nombreProducto,0,strlen($nombreProducto)-1);

                            $product_var_tpl['customization'][] = [
                                'customization_text' => $nombreProducto,
                                'customization_quantity' => $contador,
                               // 'quantity' => Tools::getContextLocale($this->context)->formatPrice($customization_quantity * $product_price, $this->context->currency->iso_code),
                            ];
                        }



                        $product_var_tpl_list[] = $product_var_tpl;
                        // Check if is not a virtual product for the displaying of shipping
                        if (!$product['is_virtual']) {
                            $virtual_product &= false;
                        }
                    }


                }


                // $fee = $this->getFee($params['cart']);

                /*   $products = array();
                   $products[] = array(
                       'id_product' => '999999999',
                       'reference' => 'PPWF',
                       'name' => 'z ' . $this->l('PayPal Fee'),
                       'price' => Tools::displayPrice($fee['fee_with_tax'], $this->context->currency, false),
                       'quantity' => '1',
                       'customization' => array(),
                       'unit_price' => Tools::displayPrice($fee['fee_without_tax'], $this->context->currency, false),
                       'unit_price_full' => Tools::displayPrice($fee['fee_without_tax'], $this->context->currency, false),
                   );*/

                $product_list_txt = $this->getEmailTemplateContent(
                    'order_conf_product_list.txt',
                    Mail::TYPE_TEXT,
                    $product_var_tpl_list
                );
                $product_list_html = $this->getEmailTemplateContent(
                    'order_conf_product_list.tpl',
                    Mail::TYPE_HTML,
                    $product_var_tpl_list
                );

                $params['template_vars']['{products}'] = $product_list_html;
                $params['template_vars']['{products_txt}'] = $product_list_txt;

            }
        }
    }


    /**
     * @return MailPartialTemplateRenderer
     */
    public function getPartialRenderer()
    {
        if (!$this->partialRenderer) {
            $this->partialRenderer = new MailPartialTemplateRenderer($this->context->smarty);
        }

        return $this->partialRenderer;
    }

    /**
     * Fetch the content of $template_name inside the folder
     * current_theme/mails/current_iso_lang/ if found, otherwise in
     * mails/current_iso_lang.
     *
     * @param string $template_name template name with extension
     * @param int $mail_type Mail::TYPE_HTML or Mail::TYPE_TEXT
     * @param array $var sent to smarty as 'list'
     *
     * @return string
     */
    public function getEmailTemplateContent($template_name, $mail_type, $var)
    {
        $email_configuration = Configuration::get('PS_MAIL_TYPE');
        if ($email_configuration != $mail_type && $email_configuration != Mail::TYPE_BOTH) {
            return '';
        }

        return $this->getPartialRenderer()->render($template_name, $this->context->language, $var);
    }

    


    public function hookActionValidateOrder($params)
    {
        $cart = $params['cart']; // The cart object
        $id_lang = $this->context->language->id;
        $order_status = $params['orderStatus']; // The order status
        $order = $params['order']; // And the order object
       // $products=$cart->getProducts(true);
        //$order->id; // This is the id order
        

             $product_carts = customCartsCart::getProductosCart($cart->id, $id_lang);
            foreach ($product_carts as $product_cart) {
                customCartsOrder::insertProductOrder((int)$order->id, $product_cart['cesta'],$product_cart['product_attribute_id'], $product_cart['componente'], $product_cart['alternativo'], $product_cart['intercambiable'], $product_cart['name']);
            }
        
    }

    private function installSQL()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS`' . _DB_PREFIX_ . 'customcarts_order_detail` (
                    `id` int(10) AUTO_INCREMENT NOT NULL,
                    `id_order` int(10),
                    `cesta` int(10),
                    `product_attribute_id` int(10),
                    `componente` int(10),
                    `alternativo` TINYINT(1),
                    `intercambiable` TINYINT(1),
                    `name` VARCHAR(255),
                    `date_add` DATETIME,
                    `date_upd` DATETIME,
                    PRIMARY KEY (`id`)
                    ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';


        $sql .= 'CREATE TABLE IF NOT EXISTS`' . _DB_PREFIX_ . 'customcarts_cart_detail` (
                    `id` int(10) AUTO_INCREMENT NOT NULL,
                    `id_cart` int(10),
                    `cesta` int(10),
                    `product_attribute_id` int(10),
                    `componente` int(10),
                    `alternativo` TINYINT(1),
                    `intercambiable` TINYINT(1),
                    `name` VARCHAR(255),
                    `date_add` DATETIME,
                    `date_upd` DATETIME,
                    PRIMARY KEY (`id`)
                    ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';



        $sql .= 'CREATE TABLE IF NOT EXISTS`' . _DB_PREFIX_ . 'customcarts_table` (
                    `id` int(10) AUTO_INCREMENT NOT NULL,
                    `cesta` int(10),
                    `componente` int(10),
                    `alternativo` TINYINT(1),
                    `intercambiable` TINYINT(1),
                    PRIMARY KEY (`id`)
                    ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

        if (!DB::getInstance()->execute($sql)) {
            return false;
        }

        return true;
    }

    private function uninstallSQL()
    {

        $sql = 'DROP TABLE IF EXISTS`' . _DB_PREFIX_ . 'customcarts_table`;DROP TABLE IF EXISTS`' . _DB_PREFIX_ . 'customcarts_order_detail`;DROP TABLE IF EXISTS`' . _DB_PREFIX_ . 'customcarts_cart_detail`';

        if (!DB::getInstance()->execute($sql)) {
            return false;
        }

        Configuration::deleteByName('CUSTOMCARTS_PARAMETROCONTROL');


        return parent::uninstall();
    }

    public function hookAddWebserviceResources($params) {
        return [
            'customcartsob' => [
                'description' => 'Entity customcarts table precognis',
                'class' => 'customCartsOb'
            ],
            'customcartsorder' => [
                'description' => 'Entity customcartsorderdetail table precognis',
                'class' => 'customCartsOrder'
            ],
            'customcartscart' => [
                'description' => 'Entity customcartscartdetail table precognis',
                'class' => 'customCartsCart'
            ],
        ];
    }





}



//displayOrderConfirmation//









/*INSERT INTO `ps_customcarts_cart_detail` (`id`, `id_cart`, `cesta`, `componente`, `alternativo`, `intercambiable`, `name`, `date_add`, `date_upd`)
VALUES
(1, 12, 1, 44, 1, 1, NULL, NULL, NULL),
	(2, 12, 1, 31, 1, 1, NULL, NULL, NULL),
	(3, 12, 1, 49, 1, 1, NULL, NULL, NULL),
	(4, 12, 1, 36, 1, 1, NULL, NULL, NULL);*/



/*displayCestaPersonalizada*/