<?php
/**
 * 2007-2020 PrestaShop
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
 *  @copyright 2007-2022 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

include '../../config/config.inc.php';

include './customentregasencurso.php';
$idProduct = $_REQUEST['idProduct'];
// $idCategory = $_REQUEST['id_category_default'];
$country = $_REQUEST['country'];             //Context::getContext()->country->id;
$ce = new CustomEntregasEnCurso();
$info = $ce->datoProducto($idProduct);
//cambio para pais
$info['grossUnitPrice']=number_format((float) SpecificPrice::getSpecificPrice($idProduct,Context::getContext()->shop->id,Context::getContext()->currency->id,$country,Customer::getDefaultGroupId(Context::getContext()->customer->id),1)['price'], 2, '.', '');
json_encode($info);

