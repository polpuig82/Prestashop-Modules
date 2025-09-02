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
class CustomSuscripcionesSuscripcionesListModuleFrontController extends ModuleFrontController
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
        $params = array("clientId" => $id_customer, "encurso" => 1);
        $suscripciones = CustomSuscripciones::wsOBCall($params);
        $id_lang = Context::getContext()->language->id;
        $productosrecomendados1 = customObSuscripciones::getProductosRecomendados1($id_lang);
        $productosrecomendados2 = customObSuscripciones::getProductosRecomendados2($id_lang);
        $productosrecomendados3 = customObSuscripciones::getProductosRecomendados3($id_lang);
        $productossuscripcion1 = customObSuscripciones::getProductosSuscripcion1($id_lang);

        
        // $productosrecomendados4 = customOb::getProductosRecomendados4($id_lang);

        $this->context->smarty->assign(
            [
                'suscripciones' => $suscripciones,
                'tituloCarrousel1_ES' => Configuration::get('CUSTOMCARROUSELS_TITLE_1_ES'),
                'tituloCarrousel1_CA' => Configuration::get('CUSTOMCARROUSELS_TITLE_1_CA'),
                'descCarrousel1_ES' => Configuration::get('CUSTOMCARROUSELS_DESC_1_ES'),
                'descCarrousel1_CA' => Configuration::get('CUSTOMCARROUSELS_DESC_1_CA'),
                'tituloCarrousel2_ES' => Configuration::get('CUSTOMCARROUSELS_TITLE_2_ES'),
                'tituloCarrousel2_CA' => Configuration::get('CUSTOMCARROUSELS_TITLE_2_CA'),
                'descCarrousel2_ES' => Configuration::get('CUSTOMCARROUSELS_DESC_2_ES'),
                'descCarrousel2_CA' => Configuration::get('CUSTOMCARROUSELS_DESC_2_CA'),
                'tituloCarrousel3_ES' => Configuration::get('CUSTOMCARROUSELS_TITLE_3_ES'),
                'tituloCarrousel3_CA' => Configuration::get('CUSTOMCARROUSELS_TITLE_3_CA'),
                'descCarrousel3_ES' => Configuration::get('CUSTOMCARROUSELS_DESC_3_ES'),
                'descCarrousel3_CA' => Configuration::get('CUSTOMCARROUSELS_DESC_3_CA'),
                'tituloCarrousel4_ES' => Configuration::get('CUSTOMCARROUSELS_TITLE_4_ES'),
                'tituloCarrousel4_CA' => Configuration::get('CUSTOMCARROUSELS_TITLE_4_CA'),
                'descCarrousel4_ES' => Configuration::get('CUSTOMCARROUSELS_DESC_4_ES'),
                'descCarrousel4_CA' => Configuration::get('CUSTOMCARROUSELS_DESC_4_CA'),
                'tituloCarrouselSuscripciones1_ES' => Configuration::get('CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_ES'),
                'tituloCarrouselSuscripciones1_CA' => Configuration::get('CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_CA'),
                'descCarrouselSuscripciones1_ES' => Configuration::get('CUSTOMCARROUSELSSUSCRIPCION_DESC_1_ES'),
                'descCarrouselSuscripciones1_CA' => Configuration::get('CUSTOMCARROUSELSSUSCRIPCION_DESC_1_CA'),
                'productosrecomendados1' => $productosrecomendados1,
                'productosrecomendados2' => $productosrecomendados2,
                'productosrecomendados3' => $productosrecomendados3,
                'productossuscripcion1' => $productossuscripcion1,
                'productosrecomendados4' => '',
                'id_lang' => $id_lang,
            ]
        );

        /*   $this->context->smarty->assign(
        [
        'url' => $this->context->link->getModuleLink('blockwishlist', 'action', ['action' => 'getAllWishlist']),
        'createUrl' => $this->context->link->getModuleLink('blockwishlist', 'action', ['action' => 'createNewWishlist']),
        'deleteListUrl' => $this->context->link->getModuleLink('blockwishlist', 'action', ['action' => 'deleteWishlist']),
        'deleteProductUrl' => $this->context->link->getModuleLink('blockwishlist', 'action', ['action' => 'deleteProductFromWishlist']),
        'renameUrl' => $this->context->link->getModuleLink('blockwishlist', 'action', ['action' => 'renameWishlist']),
        'shareUrl' => $this->context->link->getModuleLink('blockwishlist', 'action', ['action' => 'getUrlByIdWishlist']),
        'addUrl' => $this->context->link->getModuleLink('blockwishlist', 'action', ['action' => 'addProductToWishlist']),
        'accountLink' => '#',
        'wishlistsTitlePage' => Configuration::get('blockwishlist_WishlistPageName', $this->context->language->id),
        'newWishlistCTA' => Configuration::get('blockwishlist_CreateButtonLabel', $this->context->language->id),
        ]
        );

        $this->context->controller->registerJavascript(
        'blockwishlistController',
        'modules/blockwishlist/public/wishlistcontainer.bundle.js',
        [
        'priority' => 200,
        ]
        );*/

        $this->setTemplate('module:customsuscripciones/views/templates/front/suscripciones.tpl');
    }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();

        $breadcrumb['links'][] = $this->addMyAccountToBreadcrumb();
        $lengua = Context::getContext()->language->id;

        // if($lengua==1){
        //     $breadcrumb['links'][] = [
        //         'title' => $this->l('Suscripciones'),
        //         'url' => $this->context->link->getModuleLink('customsuscripciones', 'suscripcioneslist'),
        //     ];
        // }elseif($lengua==3){
        //     $breadcrumb['links'][] = [
        //         'title' => $this->l('Subscripcions'),
        //         'url' => $this->context->link->getModuleLink('customsuscripciones', 'suscripcioneslist'),
        //     ];
        //     },
        
        $breadcrumb['links'][] = [
            'title' => $this->l('Suscripciones'),
            'url' => $this->context->link->getModuleLink('customsuscripciones', 'suscripcioneslist'),
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
                $return = [
                    'view' => $this->l('No existen resultados para la búsqueda'),
                    'data' => [
                        'contador' => $contadorGeneral,
                    ],
                ];
            } else {
                // Asignamos los datos a devolver
                $this->context->smarty->assign(
                    [
                        'contadorGeneral' => $contadorGeneral,
                        'productosrecomendados' => $productosrecomendados,
                    ]
                );

                // Cargamos la plantilla
                $return = [
                    'view' => $this->context->smarty->fetch('module:customentregasencurso/views/templates/front/search/_partials/results.tpl'),
                    'data' => [
                        'contador' => $contadorGeneral,
                    ],
                ];
            }
        } else {
            $return = [
                'view' => '',
                'data' => [
                    'contador' => $contadorGeneral,
                ],
            ];
        }

        $this->ajaxRender(
            json_encode($return)
        );

    }
}
