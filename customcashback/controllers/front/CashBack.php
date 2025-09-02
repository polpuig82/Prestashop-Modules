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
class CustomCashBackCashBackModuleFrontController extends ModuleFrontController
{
    /**
     * @var bool If set to true, will be redirected to authentication page
     */
    public $auth = true;

    public function initContent()
    {
       $id_customer=$this->context->customer->id;
       
        parent::initContent();
        $params = array("clientId" => $id_customer,"detail"=> 1);
        $CashBack=CustomCashBack::wsOBCall($params);
        // pedido
        $params = array("clientId" => $id_customer, "encurso" => 1);
        $pedidosencurso = CustomCashBack::wsOBCallOrderInProgress($params);
        customOb::setPedidosEnCurso($pedidosencurso);


        $id_lang=Context::getContext()->language->id;

        $this->context->smarty->assign(
            [
                'CashBack' => $CashBack,
                'pedidosencurso' => $pedidosencurso,
            ]
        );

        $this->setTemplate('module:customcashback/views/templates/front/cashBack.tpl');
    }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();

        $breadcrumb['links'][] = $this->addMyAccountToBreadcrumb();
        $breadcrumb['links'][] = [
            'title' => $this->l('Mi Saldo'),
            'url' => $this->context->link->getModuleLink('customCashBack', 'CashBack'),
        ];

        return $breadcrumb;
    }
}