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
class CustomHistoricoHistoricoModuleFrontController extends ModuleFrontController
{
    /**
     * @var bool If set to true, will be redirected to authentication page
     */
    public $auth = true;

    public function initContent()
    {
       $id_customer=$this->context->customer->id;
       
        parent::initContent();
        $params = array("clientId" => $id_customer,"encurso"=> 0);
        $historico=CustomHistorico::wsOBCall($params);
        $id_lang=Context::getContext()->language->id;

        $this->context->smarty->assign(
            [
                'historico' => $historico,
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



        $this->setTemplate('module:customhistorico/views/templates/front/historico.tpl');
    }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();

        $breadcrumb['links'][] = $this->addMyAccountToBreadcrumb();

                // Crear la variable $title con el valor correspondiente según el idioma
                if ($this->context->language->iso_code == 'es') {
                    $title = 'Historial de Pedidos';
                } elseif ($this->context->language->iso_code == 'ca') {
                    $title = 'Historial de Comandes';
                } else {
                    $title = 'Order History'; // Si el idioma no es español ni catalán, se muestra en inglés
                }
                
                // Agregar el enlace al breadcrumb
                $breadcrumb['links'][] = [
                    'title' => $this->l($title),
                    'url' => $this->context->link->getModuleLink('customhistorico', 'historico'),
                ];

        return $breadcrumb;
    }
}