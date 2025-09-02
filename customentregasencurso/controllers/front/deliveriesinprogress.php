<?php
/**
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
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */
class CustomEntregasEnCursoDeliveriesInProgressModuleFrontController extends ModuleFrontController
{
    /**
     * @var bool If set to true, will be redirected to authentication page
     */
    public $auth = true;

    public function initContent()
    {
        $id_customer = $this->context->customer->id;
        // $id_customer=38;
        parent::initContent();
        // $id_customer = 3;
        $params = array("clientId" => $id_customer, "encurso" => 1);
        $pedidosencurso = CustomEntregasEnCurso::wsOBCall($params);

        // Asegúrate de que setPedidosEnCurso se llama con los pedidos en curso
        customOb::setPedidosEnCurso($pedidosencurso);
        
        $params = array("clientId" => $id_customer,"detail"=> 0);
        $CashBack=CustomEntregasEnCurso::wsOBCallCashBack($params);
        $id_lang = Context::getContext()->language->id;
        $productosrecomendados1 = customOb::getProductosRecomendados1($id_lang);
        $productosrecomendados2 = customOb::getProductosRecomendados2($id_lang);
        $productosrecomendados3 = customOb::getProductosRecomendados3($id_lang);
        $productosrecomendados4 = customOb::getProductosRecomendados4($id_lang);
        $productosrecomendados5 = customOb::getProductosRecomendados5($id_lang);
        $productosrecomendados6 = customOb::getProductosRecomendados6($id_lang);
        $productosrecomendados7 = customOb::getProductosRecomendados7($id_lang);




        $this->context->smarty->assign(
            [
                'CashBack' => $CashBack,
                'pedidosencurso' => $pedidosencurso,
                'tituloCarrousel1_ES' => Configuration::get('CUSTOMCARROUSELS_TITLE_1_ES'),
                'tituloCarrousel1_CA' => Configuration::get('CUSTOMCARROUSELS_TITLE_1_CA'),
                'descCarrousel1_ES' => Configuration::get('CUSTOMCARROUSELS_DESC_1_ES'),
                'descCarrousel1_CA' => Configuration::get('CUSTOMCARROUSELS_DESC_1_CA'),
                'categoryCarrousel1_ES' => Configuration::get('CUSTOMCARROUSELS_CATEGORY_1_ES'),
                'categoryCarrousel1_CA' => Configuration::get('CUSTOMCARROUSELS_CATEGORY_1_CA'),
                'descCarrousel1_CA' => Configuration::get('CUSTOMCARROUSELS_DESC_1_CA'),
                'tituloCarrousel2_ES' => Configuration::get('CUSTOMCARROUSELS_TITLE_2_ES'),
                'tituloCarrousel2_CA' => Configuration::get('CUSTOMCARROUSELS_TITLE_2_CA'),
                'descCarrousel2_ES' => Configuration::get('CUSTOMCARROUSELS_DESC_2_ES'),
                'descCarrousel2_CA' => Configuration::get('CUSTOMCARROUSELS_DESC_2_CA'),
                'categoryCarrousel2_ES' => Configuration::get('CUSTOMCARROUSELS_CATEGORY_2_ES'),
                'categoryCarrousel2_CA' => Configuration::get('CUSTOMCARROUSELS_CATEGORY_2_CA'),
                'tituloCarrousel3_ES' => Configuration::get('CUSTOMCARROUSELS_TITLE_3_ES'),
                'tituloCarrousel3_CA' => Configuration::get('CUSTOMCARROUSELS_TITLE_3_CA'),
                'descCarrousel3_ES' => Configuration::get('CUSTOMCARROUSELS_DESC_3_ES'),
                'descCarrousel3_CA' => Configuration::get('CUSTOMCARROUSELS_DESC_3_CA'),
                'categoryCarrousel3_ES' => Configuration::get('CUSTOMCARROUSELS_CATEGORY_3_ES'),
                'categoryCarrousel3_CA' => Configuration::get('CUSTOMCARROUSELS_CATEGORY_3_CA'),
                'tituloCarrousel4_ES' => Configuration::get('CUSTOMCARROUSELS_TITLE_4_ES'),
                'tituloCarrousel4_CA' => Configuration::get('CUSTOMCARROUSELS_TITLE_4_CA'),
                'descCarrousel4_ES' => Configuration::get('CUSTOMCARROUSELS_DESC_4_ES'),
                'descCarrousel4_CA' => Configuration::get('CUSTOMCARROUSELS_DESC_4_CA'),
                'tituloCarrousel5_ES' => Configuration::get('CUSTOMCARROUSELS_TITLE_5_ES'),
                'tituloCarrousel5_CA' => Configuration::get('CUSTOMCARROUSELS_TITLE_5_CA'),
                'descCarrousel5_ES' => Configuration::get('CUSTOMCARROUSELS_DESC_5_ES'),
                'descCarrousel5_CA' => Configuration::get('CUSTOMCARROUSELS_DESC_5_CA'),
                'tituloCarrousel6_ES' => Configuration::get('CUSTOMCARROUSELS_TITLE_6_ES'),
                'tituloCarrousel6_CA' => Configuration::get('CUSTOMCARROUSELS_TITLE_6_CA'),
                'descCarrousel6_ES' => Configuration::get('CUSTOMCARROUSELS_DESC_6_ES'),
                'descCarrousel6_CA' => Configuration::get('CUSTOMCARROUSELS_DESC_6_CA'),
                'tituloCarrousel7_ES' => Configuration::get('CUSTOMCARROUSELS_TITLE_7_ES'),
                'tituloCarrousel7_CA' => Configuration::get('CUSTOMCARROUSELS_TITLE_7_CA'),
                'descCarrousel7_ES' => Configuration::get('CUSTOMCARROUSELS_DESC_7_ES'),
                'descCarrousel7_CA' => Configuration::get('CUSTOMCARROUSELS_DESC_7_CA'),
                'categoryCarrousel5_ES' => Configuration::get('CUSTOMCARROUSELS_CATEGORY_5_ES'),
                'categoryCarrousel5_CA' => Configuration::get('CUSTOMCARROUSELS_CATEGORY_5_CA'),
                'categoryCarrousel6_ES' => Configuration::get('CUSTOMCARROUSELS_CATEGORY_6_ES'),
                'categoryCarrousel6_CA' => Configuration::get('CUSTOMCARROUSELS_CATEGORY_6_CA'),
                'categoryCarrousel7_ES' => Configuration::get('CUSTOMCARROUSELS_CATEGORY_7_ES'),
                'categoryCarrousel7_CA' => Configuration::get('CUSTOMCARROUSELS_CATEGORY_7_CA'),
                'productosrecomendados1' => $productosrecomendados1,
                'productosrecomendados2' => $productosrecomendados2,
                'productosrecomendados3' => $productosrecomendados3,
                'productosrecomendados4' => '',
                'productosrecomendados5' => $productosrecomendados5,
                'productosrecomendados6' => $productosrecomendados6,
                'productosrecomendados7' => $productosrecomendados7,


                'id_lang' => $id_lang,
            ]
        );
        $this->context->smarty->tpl_vars['page']->value['body_classes']['page-customer-account'] = true;
        customOb::setPedidosEnCurso($pedidosencurso);

        $this->setTemplate('module:customentregasencurso/views/templates/front/entregasencurso.tpl');

    }
    
    // public function enviarLang()
    // {
    //     $id_lang = Context::getContext()->language->id;
    //     $this->$context->$smarty->assign('id_lang',$id_lang);
    // }

    // public function enviarLang()
    // {
    //     $this->context->smarty->assign(
    //         array(
    //             'my_id_lang' => Context::getContext()->language->id,
    //         )
    //     );

    //     return $this;
    // }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();

        $breadcrumb['links'][] = $this->addMyAccountToBreadcrumb();

        // Crear la variable $title con el valor correspondiente según el idioma
        if ($this->context->language->iso_code == 'es') {
            $title = 'Próximas entregas';
        } elseif ($this->context->language->iso_code == 'ca') {
            $title = 'Lliuraments en curs';
        } else {
            $title = 'Order History'; // Si el idioma no es español ni catalán, se muestra en inglés
        }

        $breadcrumb['links'][] = [
            'title' => $this->l($title),
            'url' => $this->context->link->getModuleLink('customentregasencurso', 'deliveriesinprogress'),
        ];

        return $breadcrumb;
    }

    public function displayAjaxSearchProduct()
    {
        $searchValue = Tools::getValue('searchValue');
        $contadorGeneral = Tools::getValue('contadorGeneral');
        // Obtenemos el contexto
        $context = Context::getContext();

        // Obtenemos la fuente completa de datos
        $productosrecomendados = customOb::getProductsForSearch($context->language->id);
        // Filtramos los datos según la variable del texto a buscar
        if (isset($productosrecomendados) && count($productosrecomendados) > 0 && $searchValue != '') {
            foreach ($productosrecomendados as $i => $producto) {
                if (strpos(strtolower($producto['name']), strtolower($searchValue)) === false) {
                    unset($productosrecomendados[$i]);
                }
            }
            $productosrecomendados = array_values($productosrecomendados);
            if (count($productosrecomendados) == 0) {
                $return = $this->l('No existen resultados para la búsqueda');
            } else {
                // Asignamos los datos a devolver
                $this->context->smarty->assign(
                    [
                        'contadorGeneral' => $contadorGeneral,
                        'productosrecomendados' => $productosrecomendados,
                    ]
                );

                // Cargamos la plantilla
                $return = $this->context->smarty->fetch('module:customentregasencurso/views/templates/front/search/_partials/results.tpl');
            }
        } else {
            $return = '';
        }

        $this->ajaxRender(
            json_encode($return)
        );

    }

    public function displayAjaxAddItem(){
        $productId = Tools::getValue('productId');
        $datosPedido = Tools::getValue('datosPedido');
        $obId = Tools::getValue('obId');
        $quantity = Tools::getValue('qty');;
        if($this->context == null){
            $this->context = Context::getContext();
        }
        $module = $this->module;
        $infoProduct = $module->datoProducto($productId);
        $datosPedido[] = [
            'id' => $productId,
            'grossUnitPrice' => $infoProduct['grossUnitPrice'],
            'active' => $infoProduct['active'],
            'image' => $infoProduct['image'],
            'name' => $infoProduct['name'],
            'quantity' => $quantity,
        ];
        $return = $module->modifyOrder($datosPedido,$obId);
        echo json_encode($return);
        die();
    }

    public function displayAjaxRemoveItem(){
        $this->displayAjaxUpdateOrder();
    }
    
    public function displayAjaxUpdateOrder(){
    try{
        $datosPedido = Tools::getValue('datosPedido');
        $obId = Tools::getValue('obId');
        if($this->context == null){
            $this->context = Context::getContext();
        }
        $module = $this->module;
        $return = $module->modifyOrder($datosPedido,$obId);

        //Se comprueba si $return es un JSON
        json_decode($return);
        if(json_last_error() === JSON_ERROR_NONE) {
            echo $return;   //si $return ya es un JSON, no se realiza el json_encode
        } else {
            echo json_encode($return);  //si $return NO es un JSON, se realiza el json_encode
        }
    }catch(Exception $ex){
            dump($ex);
            die();
        }
    }

    public function displayAjaxUndoChangeUpdateOrder(){
        try{
            $productId = (int)Tools::getValue('productId');
            $datosPedido = Tools::getValue('datosPedido');
            $obId = Tools::getValue('obId');
            if($this->context == null){
                $this->context = Context::getContext();
            }
            $module = $this->module;
            $return = [];
            $infoProduct = $module->datoProducto($productId);
            $result = $module->modifyOrder($datosPedido,$obId);
            $return = [
                'infoProduct' => $infoProduct,
                'result' => $result,
            ];
            echo json_encode($return);
            die();
        }catch(Exception $ex){
            dump($ex);
            die();
        }
    }
}
