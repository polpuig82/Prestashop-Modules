{*
* 2007-2015 PrestaShop
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
*  @author    Sébastien Rufer <sebastien@rufer.fr>
*  @copyright 2016 Sébastien Rufer
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

    <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12"  id="customhistorico-link" href="{$link->getModuleLink('customhistorico', 'historico')|escape:'htmlall':'UTF-8'}" title="{l s='Historial De Pedidos' mod='customhistorico'}">
       <span class="link-item">
        {* <i class="fa fa-history">&nbsp;&nbsp;</i> *}
        <img src="/img/cms/pedidos_anteriores@2x.png" alt="marker icono" width="21" height="21">&nbsp;&nbsp;</img>
        {l s='Historial De Pedidos' mod='customhistorico'}
       </span>
    </a>


