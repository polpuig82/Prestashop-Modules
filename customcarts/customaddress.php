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

include_once dirname(__FILE__) . '/classes/deliverySlot.php';

class CustomAddress extends Module
{


    public function __construct()
    {
        $this->name = 'customaddress';
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

        $this->displayName = $this->l('Custom Address D&V OpenBravo Carrier');
        $this->description = $this->l('Module for customization address enjoy&vegetables.');
        $this->configure = true;
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

    }

    public function install()
    {
        $result = true;
        if (!parent::install()
            || !$this->registerHook('additionalCustomerAddressFields')
           // || !$this->registerHook('actionCustomerAddressGridDefinitionModifier')
          //  || !$this->registerHook('actionCustomerAddressGridQueryBuilderModifier')
            || !$this->registerHook('displaySelectCity')
            || !$this->registerHook('displaySelectDeliveryDate')
         //   || !$this->registerHook('displayBeforeCarrier')
            || !$this->registerHook('displayHeader')
        ) {
            $result = false;
        }

       /* $res =(bool)Db::getInstance()->execute(
            'ALTER TABLE `'._DB_PREFIX_.'address`  ADD `deliverySlotId` varchar(255) NULL,ADD `slotName` varchar(255) NULL, ADD `slotDay` int'
        );*/

        Configuration::updateValue('CUSTOMADDRESS_URLOB', '');
        Configuration::updateValue('CUSTOMADDRESS_USERNAME_OB', '');
        Configuration::updateValue('CUSTOMADDRESS_PASSWORD_OB', '');

        return $result;

    }

    public function getContent()
    {
        $output = null;
        $errors = array();
        if (Tools::isSubmit('submit' . $this->name)) {
            $parametro = Tools::getValue('CUSTOMADDRESS_URLOB');
            $parametro1 = Tools::getValue('CUSTOMADDRESS_USERNAME_OB');
            $parametro2 = Tools::getValue('CUSTOMADDRESS_PASSWORD_OB');
            if (!Configuration::updateValue('CUSTOMADDRESS_URLOB', $parametro)) {
                $errors[] = $this->trans('It has not been updated correctly');
            }
            if (!Configuration::updateValue('CUSTOMADDRESS_USERNAME_OB', $parametro1)) {
                $errors[] = $this->trans('It has not been updated correctly');
            }
            if (!Configuration::updateValue('CUSTOMADDRESS_PASSWORD_OB', $parametro2)) {
                $errors[] = $this->trans('It has not been updated correctly');
            }
            $output .= $this->displayConfirmation($this->l('Update done successfully'));
        }



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
                    'label' => $this->l('URL OpenBravo Manage Address Delivery'),
                    'name'  => 'CUSTOMADDRESS_URLOB',
                    'desc'  => $this->l('URL With Https'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('USERNAME OpenBravo Manage Address Delivery'),
                    'name'  => 'CUSTOMADDRESS_USERNAME_OB',
                    'desc'  => $this->l('Username Open Bravo'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('PASSWORD OpenBravo Manage Address Delivery'),
                    'name'  => 'CUSTOMADDRESS_PASSWORD_OB',
                    'desc'  => $this->l('Password Open Bravo'),
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
        $helper->fields_value['CUSTOMADDRESS_URLOB']    = Configuration::get('CUSTOMADDRESS_URLOB');
        $helper->fields_value['CUSTOMADDRESS_USERNAME_OB']    = Configuration::get('CUSTOMADDRESS_USERNAME_OB');
        $helper->fields_value['CUSTOMADDRESS_PASSWORD_OB']    = Configuration::get('CUSTOMADDRESS_PASSWORD_OB');
        return $helper->generateForm($fields_form);
    }


    public function uninstall()
    {
        if (!parent::uninstall()
        ) {
            return false;
        }
     /*   $res =(bool)Db::getInstance()->execute(
            'ALTER TABLE `'._DB_PREFIX_.'address` DROP `deliverySlotId`,DROP `slotName`, DROP `slotDay`'
        );*/
        return true;
    }

    public function hookAdditionalCustomerAddressFields($params)
    {
        $address=null;
        if (Tools::getIsset('id_address')) {
            $address = new Address(Tools::getValue('id_address'));
        }
        //return $this->display(__FILE__, 'views/templates/front/modalSelector.tpl');
        $formField = new FormField();
        $formField->setName('deliveryslotid');
        $formField->setType('hidden');
        $formField->setLabel($this->l('deliverySlotId'));
        $formField->setRequired(false);
        if($address)
                $formField->setValue($address->deliveryslotid);


        $formField3 = new FormField();
        $formField3->setName('slotday');
        $formField3->setType('hidden');
        $formField3->setLabel($this->l('slotDay'));
        $formField3->setRequired(false);

        if($address)
            $formField3->setValue($address->slotday);



        return array($formField,$formField3);
    }



    public function hookDisplaySelectCity($params)
    {
        if (empty($_SERVER['HTTPS'])) {
            $protocolo = 'http://';
        } else {
            $protocolo = 'https://';
        }
        $urlCheckCP = $protocolo . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__ . "modules/customaddress/whoisCP.php";
        $urlCheckProvincias = $protocolo . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__ . "modules/customaddress/getProvincias.php";

        $this->context->smarty->assign(array(
            'urlCheckCP'   => $urlCheckCP,
            'urlCheckProvincias'   => $urlCheckProvincias,
        ));

        return $this->display(__FILE__, 'views/templates/front/selectorCity.tpl');

    }

    public function hookDisplaySelectDeliveryDate($params)
    {
        if (empty($_SERVER['HTTPS'])) {
            $protocolo = 'http://';
        } else {
            $protocolo = 'https://';
        }
        $urlCheckCP = $protocolo . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__ . "modules/customaddress/whoisCP.php";

        $id_address_delivery=$params['id_address'];
        $address= new Address($id_address_delivery);
        $this->context->smarty->assign('slotday', $address->slotday);
        $this->context->smarty->assign('slotname', $address->slotname);
        $this->context->smarty->assign('deliveryslotid', $address->deliveryslotid);


        $this->context->smarty->assign(array(
            'urlCheckCP'   => $urlCheckCP,
        ));

        return $this->display(__FILE__, 'views/templates/front/deliveryDate.tpl');

    }

    public function hookDisplayHeader($params)
    {

        $this->context->controller->addCSS($this->_path . 'views/css/front.css');

        $this->context->controller->addJS($this->_path . 'views/js/front.js');
        // Media::addJsDef(array('iqitcountdown_days' => $this->l('d.')));
        // $this->context->controller->addJS($this->_path . 'views/js/front.js');
        // $this->context->controller->addJS(_PS_JS_DIR_.'jquery/jquery-3.5.1.min.js');
    }

    public function wsOBCall($params)
    {
        $login=Configuration::get('CUSTOMADDRESS_USERNAME_OB');
        $password=Configuration::get('CUSTOMADDRESS_PASSWORD_OB');
        $url=Configuration::get('CUSTOMADDRESS_URLOB');
        $query=http_build_query($params);
        $ch = curl_init();

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
            if($this->isJson($result)){
          //  $decoded = json_decode($result);
         //   $decoded = json_decode($result, true);
            $deliverySlotsCompleto=array();
            $deliverySlots["lunes"]=array();
            $deliverySlots["martes"]=array();
            $deliverySlots["miercoles"]=array();
            $deliverySlots["jueves"]=array();
            $deliverySlots["viernes"]=array();
            $deliverySlots["sabado"]=array();
            $deliverys = json_decode($result,true);
            $deliverys=$deliverys['deliverySlots'];
            foreach ($deliverys as $del)
            {
                $deliverySlot= new deliverySlot();
                $deliverySlot->deliverySlotId=$del['deliverySlotId'];
                $del['slotName']=str_replace(" a "," - ",$del['slotName']);
                $del['slotName']=str_replace("Lunes de ","",$del['slotName']);
                $del['slotName']=str_replace("Martes de ","",$del['slotName']);
                $del['slotName']=str_replace("Miércoles de ","",$del['slotName']);
                $del['slotName']=str_replace("Jueves de ","",$del['slotName']);
                $del['slotName']=str_replace("Viernes de ","",$del['slotName']);
                $del['slotName']=str_replace("Sábado de ","",$del['slotName']);
                $deliverySlot->slotName=$del['slotName'];
                $deliverySlot->slotDay=$del['slotDay'];

                switch ($del['slotDay'])
                {
                    case 1: array_push($deliverySlots["lunes"],$deliverySlot);break;
                    case 2: array_push($deliverySlots["martes"],$deliverySlot);break;
                    case 3: array_push($deliverySlots["miercoles"],$deliverySlot);break;
                    case 4: array_push($deliverySlots["jueves"],$deliverySlot);break;
                    case 5: array_push($deliverySlots["viernes"],$deliverySlot);break;
                    case 6: array_push($deliverySlots["sabado"],$deliverySlot);break;

                }


            }

            $result=json_encode(
                array_merge(
                    json_decode($result, true),
                    $deliverySlots
                )
            );


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


    public function hookDisplayBeforeCarrier($params)
    {/*

        $id_address_delivery=$params['cart']->id_address_delivery;
        $address= new Address($id_address_delivery);
        $this->context->smarty->assign('deliveryslotidSeleccionado', $address->deliveryslotid);
        $this->context->smarty->assign('codPostal', $address->postcode);

        if (empty($_SERVER['HTTPS'])) {
            $protocolo = 'http://';
        } else {
            $protocolo = 'https://';
        }
        $urlCheckCP = $protocolo . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__ . "modules/customaddress/whoisCP.php";

        $this->context->smarty->assign(array(
            'urlCheckCP'   => $urlCheckCP,
        ));
                return $this->display(__FILE__, 'views/templates/front/order.tpl');
    */
    }



    /*public function hookActionAddressAccountAdd($params)
    {
        $customerId =$params['newCustomer']->id;
        $delivery= Tools::getValue('delivery','');
        return (bool) Db::getInstance()->execute('update '._DB_PREFIX_.'customer set deliveryOB=\''.pSQL($delivery)."' WHERE id_customer=".(int) $customerId);
    }
    public function hookActionAdminAddressListingFieldsModifier($params)
    {
        $params['fields']['deliveryOB'] = array(
            'title' => $this->l('Delivery'),
            'align' => 'center',
        );
    }*/
    public function hookActionCustomerAddressGridDefinitionModifier(array $params)
    {
        /** @var GridDefinitionInterface $definition */
        $definition = $params['definition'];

        $definition
            ->getColumns()
            ->addAfter(
                'optin',
                (new DataColumn('delivery'))
                    ->setName($this->l('Delivery'))
                    ->setOptions([
                        'field' => 'slotName',
                    ])
            )
        ;

        // For search filter
        $definition->getFilters()->add(
            (new Filter('delivery', TextType::class))
                ->setAssociatedColumn('delivery')
        );
    }

    public function hookActionCustomerAddressGridQueryBuilderModifier(array $params)
    {
        /** @var QueryBuilder $searchQueryBuilder */
        $searchQueryBuilder = $params['search_query_builder'];

        /** @var CustomerFilters $searchCriteria */
        $searchCriteria = $params['search_criteria'];

        $searchQueryBuilder->addSelect(
            'IF(wcm.`slotName` IS NULL,0,wcm.`slotName`) AS `slotName`'
        );

        $searchQueryBuilder->leftJoin(
            'a',
            '`' . pSQL(_DB_PREFIX_) . 'address`',
            'wcm',
            'wcm.`id_address` = a.`id_address`'
        );

        if ('phone' === $searchCriteria->getOrderBy()) {
            $searchQueryBuilder->orderBy('wcm.`slotName`', $searchCriteria->getOrderWay());
        }

        foreach ($searchCriteria->getFilters() as $filterName => $filterValue) {
            if ('phone' === $filterName) {
                $searchQueryBuilder->andWhere('wcm.`slotName` = :slotName');
                $searchQueryBuilder->setParameter('slotName', $filterValue);

                if (!$filterValue) {
                    $searchQueryBuilder->orWhere('wcm.`slotName` IS NULL');
                }
            }
        }
    }

    public function isJson($string)

    { return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false; }


    public function getStates($id_country)
    {
        return Db::getInstance()->ExecuteS('
            SELECT `id_state`, `name` FROM `'._DB_PREFIX_.'state` WHERE active = 1 and id_country="'.$id_country.'" ORDER BY `name` ASC');

    }

}

