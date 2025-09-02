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
 *  @copyright 2007-2020 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_')) {
    exit;
}
class customCarrousels extends Module
{

    public function __construct()
    {
        $this->name = 'customcarrousels';
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

        $this->displayName = $this->l('Custom Carrousels Area D&V OpenBravo');
        $this->configure   = true;
        $this->description = $this->l('Module for view carrousels in enjoy&vegetables.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    public function getContent()
    {
        $output = null;
        $errors = array();
        if (Tools::isSubmit('submit' . $this->name)) {
            $CUSTOMCARROUSELS_1_ES   = (string) (Tools::getValue('CUSTOMCARROUSELS_1_ES'));
            $CUSTOMCARROUSELS_1_CA   = (string) (Tools::getValue('CUSTOMCARROUSELS_1_CA'));
            $CUSTOMCARROUSELS_TITLE_1_ES    = (string) (Tools::getValue('CUSTOMCARROUSELS_TITLE_1_ES'));
            $CUSTOMCARROUSELS_TITLE_1_CA    = (string) (Tools::getValue('CUSTOMCARROUSELS_TITLE_1_CA'));
            $CUSTOMCARROUSELS_DESC_1_ES    = (string) (Tools::getValue('CUSTOMCARROUSELS_DESC_1_ES'));
            $CUSTOMCARROUSELS_DESC_1_CA    = (string) (Tools::getValue('CUSTOMCARROUSELS_DESC_1_CA'));
            $CUSTOMCARROUSELS_CATEGORY_1_ES = Tools::getValue('CUSTOMCARROUSELS_CATEGORY_1_ES');
            $CUSTOMCARROUSELS_CATEGORY_1_CA = Tools::getValue('CUSTOMCARROUSELS_CATEGORY_1_CA');

            $CUSTOMCARROUSELS_2_ES    = (string) (Tools::getValue('CUSTOMCARROUSELS_2_ES'));
            $CUSTOMCARROUSELS_2_CA    = (string) (Tools::getValue('CUSTOMCARROUSELS_2_CA'));
            $CUSTOMCARROUSELS_TITLE_2_ES    = (string) (Tools::getValue('CUSTOMCARROUSELS_TITLE_2_ES'));
            $CUSTOMCARROUSELS_TITLE_2_CA    = (string) (Tools::getValue('CUSTOMCARROUSELS_TITLE_2_CA'));
            $CUSTOMCARROUSELS_DESC_2_ES    = (string) (Tools::getValue('CUSTOMCARROUSELS_DESC_2_ES'));
            $CUSTOMCARROUSELS_DESC_2_CA    = (string) (Tools::getValue('CUSTOMCARROUSELS_DESC_2_CA'));
            $CUSTOMCARROUSELS_CATEGORY_2_ES = Tools::getValue('CUSTOMCARROUSELS_CATEGORY_2_ES');
            $CUSTOMCARROUSELS_CATEGORY_2_CA = Tools::getValue('CUSTOMCARROUSELS_CATEGORY_2_CA');

            $CUSTOMCARROUSELS_3_ES     = (string) (Tools::getValue('CUSTOMCARROUSELS_3_ES'));
            $CUSTOMCARROUSELS_3_CA     = (string) (Tools::getValue('CUSTOMCARROUSELS_3_CA'));
            $CUSTOMCARROUSELS_TITLE_3_ES    = (string) (Tools::getValue('CUSTOMCARROUSELS_TITLE_3_ES'));
            $CUSTOMCARROUSELS_TITLE_3_CA    = (string) (Tools::getValue('CUSTOMCARROUSELS_TITLE_3_CA'));
            $CUSTOMCARROUSELS_DESC_3_ES    = (string) (Tools::getValue('CUSTOMCARROUSELS_DESC_3_ES'));
            $CUSTOMCARROUSELS_DESC_3_CA    = (string) (Tools::getValue('CUSTOMCARROUSELS_DESC_3_CA'));
            $CUSTOMCARROUSELS_CATEGORY_3_ES = Tools::getValue('CUSTOMCARROUSELS_CATEGORY_3_ES');
            $CUSTOMCARROUSELS_CATEGORY_3_CA = Tools::getValue('CUSTOMCARROUSELS_CATEGORY_3_CA');

            $CUSTOMCARROUSELS_4_ES   = (string) (Tools::getValue('CUSTOMCARROUSELS_4_ES'));
            $CUSTOMCARROUSELS_4_CA   = (string) (Tools::getValue('CUSTOMCARROUSELS_4_CA'));
            $CUSTOMCARROUSELS_TITLE_4_ES    = (string) (Tools::getValue('CUSTOMCARROUSELS_TITLE_4_ES'));
            $CUSTOMCARROUSELS_TITLE_4_CA    = (string) (Tools::getValue('CUSTOMCARROUSELS_TITLE_4_CA'));
            $CUSTOMCARROUSELS_DESC_4_ES    = (string) (Tools::getValue('CUSTOMCARROUSELS_DESC_4_ES'));
            $CUSTOMCARROUSELS_DESC_4_CA    = (string) (Tools::getValue('CUSTOMCARROUSELS_DESC_4_CA'));

            $CUSTOMCARROUSELS_5_ES    = (string) (Tools::getValue('CUSTOMCARROUSELS_5_ES'));
            $CUSTOMCARROUSELS_5_CA    = (string) (Tools::getValue('CUSTOMCARROUSELS_5_CA'));
            $CUSTOMCARROUSELS_TITLE_5_ES    = (string) (Tools::getValue('CUSTOMCARROUSELS_TITLE_5_ES'));
            $CUSTOMCARROUSELS_TITLE_5_CA    = (string) (Tools::getValue('CUSTOMCARROUSELS_TITLE_5_CA'));
            $CUSTOMCARROUSELS_DESC_5_ES    = (string) (Tools::getValue('CUSTOMCARROUSELS_DESC_5_ES'));
            $CUSTOMCARROUSELS_DESC_5_CA    = (string) (Tools::getValue('CUSTOMCARROUSELS_DESC_5_CA'));
            $CUSTOMCARROUSELS_CATEGORY_5_ES = Tools::getValue('CUSTOMCARROUSELS_CATEGORY_5_ES');
            $CUSTOMCARROUSELS_CATEGORY_5_CA = Tools::getValue('CUSTOMCARROUSELS_CATEGORY_5_CA');

            $CUSTOMCARROUSELS_6_ES    = (string) (Tools::getValue('CUSTOMCARROUSELS_6_ES'));
            $CUSTOMCARROUSELS_6_CA    = (string) (Tools::getValue('CUSTOMCARROUSELS_6_CA'));
            $CUSTOMCARROUSELS_TITLE_6_ES    = (string) (Tools::getValue('CUSTOMCARROUSELS_TITLE_6_ES'));
            $CUSTOMCARROUSELS_TITLE_6_CA    = (string) (Tools::getValue('CUSTOMCARROUSELS_TITLE_6_CA'));
            $CUSTOMCARROUSELS_DESC_6_ES    = (string) (Tools::getValue('CUSTOMCARROUSELS_DESC_6_ES'));
            $CUSTOMCARROUSELS_DESC_6_CA    = (string) (Tools::getValue('CUSTOMCARROUSELS_DESC_6_CA'));
            $CUSTOMCARROUSELS_CATEGORY_6_ES = Tools::getValue('CUSTOMCARROUSELS_CATEGORY_6_ES');
            $CUSTOMCARROUSELS_CATEGORY_6_CA = Tools::getValue('CUSTOMCARROUSELS_CATEGORY_6_CA');

            $CUSTOMCARROUSELS_7_ES    = (string) (Tools::getValue('CUSTOMCARROUSELS_7_ES'));
            $CUSTOMCARROUSELS_7_CA    = (string) (Tools::getValue('CUSTOMCARROUSELS_7_CA'));
            $CUSTOMCARROUSELS_TITLE_7_ES    = (string) (Tools::getValue('CUSTOMCARROUSELS_TITLE_7_ES'));
            $CUSTOMCARROUSELS_TITLE_7_CA    = (string) (Tools::getValue('CUSTOMCARROUSELS_TITLE_7_CA'));
            $CUSTOMCARROUSELS_DESC_7_ES    = (string) (Tools::getValue('CUSTOMCARROUSELS_DESC_7_ES'));
            $CUSTOMCARROUSELS_DESC_7_CA    = (string) (Tools::getValue('CUSTOMCARROUSELS_DESC_7_CA'));
            $CUSTOMCARROUSELS_CATEGORY_7_ES = Tools::getValue('CUSTOMCARROUSELS_CATEGORY_7_ES');
            $CUSTOMCARROUSELS_CATEGORY_7_CA = Tools::getValue('CUSTOMCARROUSELS_CATEGORY_7_CA');

            $CUSTOMCARROUSELSSUSCRIPCION_1_ES    = (string) (Tools::getValue('CUSTOMCARROUSELSSUSCRIPCION_1_ES'));
            $CUSTOMCARROUSELSSUSCRIPCION_1_CA    = (string) (Tools::getValue('CUSTOMCARROUSELSSUSCRIPCION_1_CA'));
            $CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_ES    = (string) (Tools::getValue('CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_ES'));
            $CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_CA    = (string) (Tools::getValue('CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_CA'));
            $CUSTOMCARROUSELSSUSCRIPCION_DESC_1_ES    = (string) (Tools::getValue('CUSTOMCARROUSELSSUSCRIPCION_DESC_1_ES'));
            $CUSTOMCARROUSELSSUSCRIPCION_DESC_1_CA    = (string) (Tools::getValue('CUSTOMCARROUSELSSUSCRIPCION_DESC_1_CA'));
            $CUSTOMCARROUSELSSUSCRIPCION_CATEGORY_1_ES = Tools::getValue('CUSTOMCARROUSELSSUSCRIPCION_CATEGORY_1_ES');
            $CUSTOMCARROUSELSSUSCRIPCION_CATEGORY_1_CA = Tools::getValue('CUSTOMCARROUSELSSUSCRIPCION_CATEGORY_1_CA');


            Configuration::updateValue('CUSTOMCARROUSELS_1_ES', $CUSTOMCARROUSELS_1_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_1_CA', $CUSTOMCARROUSELS_1_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_1_ES', $CUSTOMCARROUSELS_TITLE_1_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_1_ES', $CUSTOMCARROUSELS_DESC_1_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_1_CA', $CUSTOMCARROUSELS_TITLE_1_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_1_CA', $CUSTOMCARROUSELS_DESC_1_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_CATEGORY_1_ES', $CUSTOMCARROUSELS_CATEGORY_1_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_CATEGORY_1_CA', $CUSTOMCARROUSELS_CATEGORY_1_CA);
            

            Configuration::updateValue('CUSTOMCARROUSELS_2_ES', $CUSTOMCARROUSELS_2_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_2_CA', $CUSTOMCARROUSELS_2_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_2_ES', $CUSTOMCARROUSELS_TITLE_2_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_2_ES', $CUSTOMCARROUSELS_DESC_2_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_2_CA', $CUSTOMCARROUSELS_TITLE_2_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_2_CA', $CUSTOMCARROUSELS_DESC_2_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_CATEGORY_2_ES', $CUSTOMCARROUSELS_CATEGORY_2_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_CATEGORY_2_CA', $CUSTOMCARROUSELS_CATEGORY_2_CA);

            Configuration::updateValue('CUSTOMCARROUSELS_3_ES', $CUSTOMCARROUSELS_3_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_3_CA', $CUSTOMCARROUSELS_3_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_3_ES', $CUSTOMCARROUSELS_TITLE_3_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_3_ES', $CUSTOMCARROUSELS_DESC_3_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_3_CA', $CUSTOMCARROUSELS_TITLE_3_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_3_CA', $CUSTOMCARROUSELS_DESC_3_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_CATEGORY_3_ES', $CUSTOMCARROUSELS_CATEGORY_3_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_CATEGORY_3_CA', $CUSTOMCARROUSELS_CATEGORY_3_CA);

            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_4_ES', $CUSTOMCARROUSELS_TITLE_4_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_4_ES', $CUSTOMCARROUSELS_DESC_4_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_4_CA', $CUSTOMCARROUSELS_TITLE_4_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_4_CA', $CUSTOMCARROUSELS_DESC_4_CA);

            if (!Configuration::updateValue('CUSTOMCARROUSELS_4_ES', $CUSTOMCARROUSELS_4_ES)) {
                $errors[] = $this->trans('It has not been updated correctly');
            }
            elseif (!Configuration::updateValue('CUSTOMCARROUSELS_4_CA', $CUSTOMCARROUSELS_4_CA)) {
                $errors[] = $this->trans('It has not been updated correctly');
            }

            Configuration::updateValue('CUSTOMCARROUSELS_5_ES', $CUSTOMCARROUSELS_5_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_5_CA', $CUSTOMCARROUSELS_5_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_5_ES', $CUSTOMCARROUSELS_TITLE_5_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_5_ES', $CUSTOMCARROUSELS_DESC_5_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_5_CA', $CUSTOMCARROUSELS_TITLE_5_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_5_CA', $CUSTOMCARROUSELS_DESC_5_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_CATEGORY_5_ES', $CUSTOMCARROUSELS_CATEGORY_5_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_CATEGORY_5_CA', $CUSTOMCARROUSELS_CATEGORY_5_CA);

            Configuration::updateValue('CUSTOMCARROUSELS_6_ES', $CUSTOMCARROUSELS_6_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_6_CA', $CUSTOMCARROUSELS_6_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_6_ES', $CUSTOMCARROUSELS_TITLE_6_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_6_ES', $CUSTOMCARROUSELS_DESC_6_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_6_CA', $CUSTOMCARROUSELS_TITLE_6_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_6_CA', $CUSTOMCARROUSELS_DESC_6_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_CATEGORY_6_ES', $CUSTOMCARROUSELS_CATEGORY_6_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_CATEGORY_6_CA', $CUSTOMCARROUSELS_CATEGORY_6_CA);

            Configuration::updateValue('CUSTOMCARROUSELS_7_ES', $CUSTOMCARROUSELS_7_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_7_CA', $CUSTOMCARROUSELS_7_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_7_ES', $CUSTOMCARROUSELS_TITLE_7_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_7_ES', $CUSTOMCARROUSELS_DESC_7_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_7_CA', $CUSTOMCARROUSELS_TITLE_7_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_7_CA', $CUSTOMCARROUSELS_DESC_7_CA);
            Configuration::updateValue('CUSTOMCARROUSELS_CATEGORY_7_ES', $CUSTOMCARROUSELS_CATEGORY_7_ES);
            Configuration::updateValue('CUSTOMCARROUSELS_CATEGORY_7_CA', $CUSTOMCARROUSELS_CATEGORY_7_CA);

            Configuration::updateValue('CUSTOMCARROUSELSSUSCRIPCION_1_ES', $CUSTOMCARROUSELSSUSCRIPCION_1_ES);
            Configuration::updateValue('CUSTOMCARROUSELSSUSCRIPCION_1_CA', $CUSTOMCARROUSELSSUSCRIPCION_1_CA);
            Configuration::updateValue('CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_ES', $CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_ES);
            Configuration::updateValue('CUSTOMCARROUSELSSUSCRIPCION_DESC_1_ES', $CUSTOMCARROUSELSSUSCRIPCION_DESC_1_ES);
            Configuration::updateValue('CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_CA', $CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_CA);
            Configuration::updateValue('CUSTOMCARROUSELSSUSCRIPCION_DESC_1_CA', $CUSTOMCARROUSELSSUSCRIPCION_DESC_1_CA);
            Configuration::updateValue('CUSTOMCARROUSELSSUSCRIPCION_CATEGORY_1_ES', $CUSTOMCARROUSELSSUSCRIPCION_CATEGORY_1_ES);
            Configuration::updateValue('CUSTOMCARROUSELSSUSCRIPCION_CATEGORY_1_CA', $CUSTOMCARROUSELSSUSCRIPCION_CATEGORY_1_CA);

            

            $output .= $this->displayConfirmation($this->l('Update done successfully'));
        }


        return $output  . $this->displayForm();
    }
    public function displayForm()
    {
        // Get default language
        $default_lang = (int) Configuration::get('PS_LANG_DEFAULT');
        // Init Fields form array
        $fields_form            = array();
        $fields_form[0]['form'] = array(
            'legend'  => array(
                'title' => $this->l('Settings'),
            ),
            'input'   => array(
                 array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 1 Title ES'),
                    'name'  => 'CUSTOMCARROUSELS_TITLE_1_ES',
                    'desc'  => $this->l('Title Carrousel 1 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 1 Title CA'),
                    'name'  => 'CUSTOMCARROUSELS_TITLE_1_CA',
                    'desc'  => $this->l('Title Carrousel 1 CA'),
                ),
                  array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 1 Desc ES'),
                    'name'  => 'CUSTOMCARROUSELS_DESC_1_ES',
                    'desc'  => $this->l('Desc Carrousel 1 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 1 Desc CA'),
                    'name'  => 'CUSTOMCARROUSELS_DESC_1_CA',
                    'desc'  => $this->l('Desc Carrousel 1 CA'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 1 Ids ES'),
                    'name'  => 'CUSTOMCARROUSELS_1_ES',
                    'desc'  => $this->l('Field separator "," ids Products ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 1 Ids CA'),
                    'name'  => 'CUSTOMCARROUSELS_1_CA',
                    'desc'  => $this->l('Field separator "," ids Products CA'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 1 Category ES'),
                    'name'  => 'CUSTOMCARROUSELS_CATEGORY_1_ES',
                    'desc'  => $this->l('Select a category for Carrousel 1 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 1 Category CA'),
                    'name'  => 'CUSTOMCARROUSELS_CATEGORY_1_CA',
                    'desc'  => $this->l('Select a category for Carrousel 1 ES'),
                ),
                 array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 2 Title ES'),
                    'name'  => 'CUSTOMCARROUSELS_TITLE_2_ES',
                    'desc'  => $this->l('Title Carrousel 2 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 2 Title CA'),
                    'name'  => 'CUSTOMCARROUSELS_TITLE_2_CA',
                    'desc'  => $this->l('Title Carrousel 2 CA'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 2 Desc ES'),
                    'name'  => 'CUSTOMCARROUSELS_DESC_2_ES',
                    'desc'  => $this->l('Desc Carrousel 2 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 2 Desc CA'),
                    'name'  => 'CUSTOMCARROUSELS_DESC_2_CA',
                    'desc'  => $this->l('Desc Carrousel 2 CA'),
                ),
               
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 2 Ids ES'),
                    'name'  => 'CUSTOMCARROUSELS_2_ES',
                    'desc'  => $this->l('Field separator "," ids Products ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 2 Ids CA'),
                    'name'  => 'CUSTOMCARROUSELS_2_CA',
                    'desc'  => $this->l('Field separator "," ids Products CA'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 2 Category ES'),
                    'name'  => 'CUSTOMCARROUSELS_CATEGORY_2_ES',
                    'desc'  => $this->l('Select a category for Carrousel 2 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 2 Category CA'),
                    'name'  => 'CUSTOMCARROUSELS_CATEGORY_2_CA',
                    'desc'  => $this->l('Select a category for Carrousel 2 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 3 Title ES'),
                    'name'  => 'CUSTOMCARROUSELS_TITLE_3_ES',
                    'desc'  => $this->l('Title Carrousel 3 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 3 Title CA'),
                    'name'  => 'CUSTOMCARROUSELS_TITLE_3_CA',
                    'desc'  => $this->l('Title Carrousel 3 CA'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 3 Desc ES'),
                    'name'  => 'CUSTOMCARROUSELS_DESC_3_ES',
                    'desc'  => $this->l('Desc Carrousel 3 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 3 Desc CA'),
                    'name'  => 'CUSTOMCARROUSELS_DESC_3_CA',
                    'desc'  => $this->l('Desc Carrousel 3 CA'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 3 Ids ES'),
                    'name'  => 'CUSTOMCARROUSELS_3_ES',
                    'desc'  => $this->l('Field separator "," ids Products ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 3 Ids CA'),
                    'name'  => 'CUSTOMCARROUSELS_3_CA',
                    'desc'  => $this->l('Field separator "," ids Products CA'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 3 Category ES'),
                    'name'  => 'CUSTOMCARROUSELS_CATEGORY_3_ES',
                    'desc'  => $this->l('Select a category for Carrousel 3 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 3 Category CA'),
                    'name'  => 'CUSTOMCARROUSELS_CATEGORY_3_CA',
                    'desc'  => $this->l('Select a category for Carrousel 3 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 5 Title ES'),
                    'name'  => 'CUSTOMCARROUSELS_TITLE_5_ES',
                    'desc'  => $this->l('Title Carrousel 5 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 5 Title CA'),
                    'name'  => 'CUSTOMCARROUSELS_TITLE_5_CA',
                    'desc'  => $this->l('Title Carrousel 5 CA'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 5 Desc ES'),
                    'name'  => 'CUSTOMCARROUSELS_DESC_5_ES',
                    'desc'  => $this->l('Desc Carrousel 5 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 5 Desc CA'),
                    'name'  => 'CUSTOMCARROUSELS_DESC_5_CA',
                    'desc'  => $this->l('Desc Carrousel 5 CA'),
                ),
               
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 5 Ids ES'),
                    'name'  => 'CUSTOMCARROUSELS_5_ES',
                    'desc'  => $this->l('Field separator "," ids Products ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 5 Ids CA'),
                    'name'  => 'CUSTOMCARROUSELS_5_CA',
                    'desc'  => $this->l('Field separator "," ids Products CA'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 5 Category ES'),
                    'name'  => 'CUSTOMCARROUSELS_CATEGORY_5_ES',
                    'desc'  => $this->l('Select a category for Carrousel 5 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 5 Category CA'),
                    'name'  => 'CUSTOMCARROUSELS_CATEGORY_5_CA',
                    'desc'  => $this->l('Select a category for Carrousel 5 ES'),
                ),
                 
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 6 Title ES'),
                    'name'  => 'CUSTOMCARROUSELS_TITLE_6_ES',
                    'desc'  => $this->l('Title Carrousel 6 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 6 Title CA'),
                    'name'  => 'CUSTOMCARROUSELS_TITLE_6_CA',
                    'desc'  => $this->l('Title Carrousel 6 CA'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 6 Desc ES'),
                    'name'  => 'CUSTOMCARROUSELS_DESC_6_ES',
                    'desc'  => $this->l('Desc Carrousel 6 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 6 Desc CA'),
                    'name'  => 'CUSTOMCARROUSELS_DESC_6_CA',
                    'desc'  => $this->l('Desc Carrousel 6 CA'),
                ),
               
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 6 Ids ES'),
                    'name'  => 'CUSTOMCARROUSELS_6_ES',
                    'desc'  => $this->l('Field separator "," ids Products ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 6 Ids CA'),
                    'name'  => 'CUSTOMCARROUSELS_6_CA',
                    'desc'  => $this->l('Field separator "," ids Products CA'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 6 Category ES'),
                    'name'  => 'CUSTOMCARROUSELS_CATEGORY_6_ES',
                    'desc'  => $this->l('Select a category for Carrousel 6 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 6 Category CA'),
                    'name'  => 'CUSTOMCARROUSELS_CATEGORY_6_CA',
                    'desc'  => $this->l('Select a category for Carrousel 6 ES'),
                ),
                
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 7 Title ES'),
                    'name'  => 'CUSTOMCARROUSELS_TITLE_7_ES',
                    'desc'  => $this->l('Title Carrousel 7 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 7 Title CA'),
                    'name'  => 'CUSTOMCARROUSELS_TITLE_7_CA',
                    'desc'  => $this->l('Title Carrousel 7 CA'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 7 Desc ES'),
                    'name'  => 'CUSTOMCARROUSELS_DESC_7_ES',
                    'desc'  => $this->l('Desc Carrousel 7 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 7 Desc CA'),
                    'name'  => 'CUSTOMCARROUSELS_DESC_7_CA',
                    'desc'  => $this->l('Desc Carrousel 7 CA'),
                ),
               
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 7 Ids ES'),
                    'name'  => 'CUSTOMCARROUSELS_7_ES',
                    'desc'  => $this->l('Field separator "," ids Products ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 7 Ids CA'),
                    'name'  => 'CUSTOMCARROUSELS_7_CA',
                    'desc'  => $this->l('Field separator "," ids Products CA'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 7 Category ES'),
                    'name'  => 'CUSTOMCARROUSELS_CATEGORY_7_ES',
                    'desc'  => $this->l('Select a category for Carrousel 7 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 7 Category CA'),
                    'name'  => 'CUSTOMCARROUSELS_CATEGORY_7_CA',
                    'desc'  => $this->l('Select a category for Carrousel 7 ES'),
                ),

                array(
                    'type' => 'html',
                    'label' => '<h4 style=" font-weight: bold;">Carrousel Sucripciones</h4>'
                ),

                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel Suscripción 1 Title ES'),
                    'name'  => 'CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_ES',
                    'desc'  => $this->l('Title Carrousel 1 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel Suscripción 1 Title CA'),
                    'name'  => 'CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_CA',
                    'desc'  => $this->l('Title Carrousel 1 CA'),
                ),
                  array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel Suscripción 1 Desc ES'),
                    'name'  => 'CUSTOMCARROUSELSSUSCRIPCION_DESC_1_ES',
                    'desc'  => $this->l('Desc Carrousel 1 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel Suscripción 1 Desc CA'),
                    'name'  => 'CUSTOMCARROUSELSSUSCRIPCION_DESC_1_CA',
                    'desc'  => $this->l('Desc Carrousel 1 CA'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel Suscripción 1 Ids ES'),
                    'name'  => 'CUSTOMCARROUSELSSUSCRIPCION_1_ES',
                    'desc'  => $this->l('Field separator "," ids Products ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel Suscripción 1 Ids CA'),
                    'name'  => 'CUSTOMCARROUSELSSUSCRIPCION_1_CA',
                    'desc'  => $this->l('Field separator "," ids Products CA'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel Suscripción 1 Category ES'),
                    'name'  => 'CUSTOMCARROUSELSSUSCRIPCION_CATEGORY_1_ES',
                    'desc'  => $this->l('Select a category for Carrousel 1 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel Suscripción 1 Category CA'),
                    'name'  => 'CUSTOMCARROUSELSSUSCRIPCION_CATEGORY_1_CA',
                    'desc'  => $this->l('Select a category for Carrousel 1 ES'),
                ),
                array(
                    'type' => 'html',
                    'label' => '<h4 style=" font-weight: bold;">Carrousel 4 (Buscador)</h4>'
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 4 Title ES'),
                    'name'  => 'CUSTOMCARROUSELS_TITLE_4_ES',
                    'desc'  => $this->l('Title Carrousel 4 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 4 Title CA'),
                    'name'  => 'CUSTOMCARROUSELS_TITLE_4_CA',
                    'desc'  => $this->l('Title Carrousel 4 CA'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 4 Desc ES'),
                    'name'  => 'CUSTOMCARROUSELS_DESC_4_ES',
                    'desc'  => $this->l('Desc Carrousel 4 ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 4 Desc CA'),
                    'name'  => 'CUSTOMCARROUSELS_DESC_4_CA',
                    'desc'  => $this->l('Desc Carrousel 4 CA'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 4 Ids ES'),
                    'name'  => 'CUSTOMCARROUSELS_4_ES',
                    'desc'  => $this->l('Field separator "," ids Products ES'),
                ),
                array(
                    'type'  => 'text',
                    'label' => $this->l('Carrousel 4 Ids CA'),
                    'name'  => 'CUSTOMCARROUSELS_4_CA',
                    'desc'  => $this->l('Field separator "," ids Products CA'),
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
        $helper->fields_value['CUSTOMCARROUSELS_1_ES']    = Configuration::get('CUSTOMCARROUSELS_1_ES');
        $helper->fields_value['CUSTOMCARROUSELS_1_CA']    = Configuration::get('CUSTOMCARROUSELS_1_CA');
        $helper->fields_value['CUSTOMCARROUSELS_TITLE_1_ES']    = Configuration::get('CUSTOMCARROUSELS_TITLE_1_ES');
        $helper->fields_value['CUSTOMCARROUSELS_TITLE_1_CA']    = Configuration::get('CUSTOMCARROUSELS_TITLE_1_CA');
        $helper->fields_value['CUSTOMCARROUSELS_DESC_1_ES']    = Configuration::get('CUSTOMCARROUSELS_DESC_1_ES');
        $helper->fields_value['CUSTOMCARROUSELS_DESC_1_CA']    = Configuration::get('CUSTOMCARROUSELS_DESC_1_CA');
        $helper->fields_value['CUSTOMCARROUSELS_CATEGORY_1_ES']    = Configuration::get('CUSTOMCARROUSELS_CATEGORY_1_ES');
        $helper->fields_value['CUSTOMCARROUSELS_CATEGORY_1_CA']    = Configuration::get('CUSTOMCARROUSELS_CATEGORY_1_CA');


        $helper->fields_value['CUSTOMCARROUSELS_2_ES']    = Configuration::get('CUSTOMCARROUSELS_2_ES');
        $helper->fields_value['CUSTOMCARROUSELS_2_CA']    = Configuration::get('CUSTOMCARROUSELS_2_CA');
        $helper->fields_value['CUSTOMCARROUSELS_TITLE_2_ES']    = Configuration::get('CUSTOMCARROUSELS_TITLE_2_ES');
        $helper->fields_value['CUSTOMCARROUSELS_TITLE_2_CA']    = Configuration::get('CUSTOMCARROUSELS_TITLE_2_CA');
        $helper->fields_value['CUSTOMCARROUSELS_DESC_2_ES']    = Configuration::get('CUSTOMCARROUSELS_DESC_2_ES');
        $helper->fields_value['CUSTOMCARROUSELS_DESC_2_CA']    = Configuration::get('CUSTOMCARROUSELS_DESC_2_CA');
        $helper->fields_value['CUSTOMCARROUSELS_CATEGORY_2_ES']    = Configuration::get('CUSTOMCARROUSELS_CATEGORY_2_ES');
        $helper->fields_value['CUSTOMCARROUSELS_CATEGORY_2_CA']    = Configuration::get('CUSTOMCARROUSELS_CATEGORY_2_CA');

        $helper->fields_value['CUSTOMCARROUSELS_3_ES']     = Configuration::get('CUSTOMCARROUSELS_3_ES');
        $helper->fields_value['CUSTOMCARROUSELS_3_CA']     = Configuration::get('CUSTOMCARROUSELS_3_CA');
        $helper->fields_value['CUSTOMCARROUSELS_TITLE_3_ES']    = Configuration::get('CUSTOMCARROUSELS_TITLE_3_ES');
        $helper->fields_value['CUSTOMCARROUSELS_TITLE_3_CA']    = Configuration::get('CUSTOMCARROUSELS_TITLE_3_CA');
        $helper->fields_value['CUSTOMCARROUSELS_DESC_3_ES']    = Configuration::get('CUSTOMCARROUSELS_DESC_3_ES');
        $helper->fields_value['CUSTOMCARROUSELS_DESC_3_CA']    = Configuration::get('CUSTOMCARROUSELS_DESC_3_CA');
        $helper->fields_value['CUSTOMCARROUSELS_CATEGORY_3_ES']    = Configuration::get('CUSTOMCARROUSELS_CATEGORY_3_ES');
        $helper->fields_value['CUSTOMCARROUSELS_CATEGORY_3_CA']    = Configuration::get('CUSTOMCARROUSELS_CATEGORY_3_CA');

        $helper->fields_value['CUSTOMCARROUSELS_4_ES']   = Configuration::get('CUSTOMCARROUSELS_4_ES');
        $helper->fields_value['CUSTOMCARROUSELS_4_CA']   = Configuration::get('CUSTOMCARROUSELS_4_CA');
        $helper->fields_value['CUSTOMCARROUSELS_TITLE_4_ES']    = Configuration::get('CUSTOMCARROUSELS_TITLE_4_ES');
        $helper->fields_value['CUSTOMCARROUSELS_TITLE_4_CA']    = Configuration::get('CUSTOMCARROUSELS_TITLE_4_CA');
        $helper->fields_value['CUSTOMCARROUSELS_DESC_4_ES']    = Configuration::get('CUSTOMCARROUSELS_DESC_4_ES');
        $helper->fields_value['CUSTOMCARROUSELS_DESC_4_CA']    = Configuration::get('CUSTOMCARROUSELS_DESC_4_CA');

        $helper->fields_value['CUSTOMCARROUSELS_5_ES']    = Configuration::get('CUSTOMCARROUSELS_5_ES');
        $helper->fields_value['CUSTOMCARROUSELS_5_CA']    = Configuration::get('CUSTOMCARROUSELS_5_CA');
        $helper->fields_value['CUSTOMCARROUSELS_TITLE_5_ES']    = Configuration::get('CUSTOMCARROUSELS_TITLE_5_ES');
        $helper->fields_value['CUSTOMCARROUSELS_TITLE_5_CA']    = Configuration::get('CUSTOMCARROUSELS_TITLE_5_CA');
        $helper->fields_value['CUSTOMCARROUSELS_DESC_5_ES']    = Configuration::get('CUSTOMCARROUSELS_DESC_5_ES');
        $helper->fields_value['CUSTOMCARROUSELS_DESC_5_CA']    = Configuration::get('CUSTOMCARROUSELS_DESC_5_CA');
        $helper->fields_value['CUSTOMCARROUSELS_CATEGORY_5_ES']    = Configuration::get('CUSTOMCARROUSELS_CATEGORY_5_ES');
        $helper->fields_value['CUSTOMCARROUSELS_CATEGORY_5_CA']    = Configuration::get('CUSTOMCARROUSELS_CATEGORY_5_CA');

        $helper->fields_value['CUSTOMCARROUSELS_6_ES']    = Configuration::get('CUSTOMCARROUSELS_6_ES');
        $helper->fields_value['CUSTOMCARROUSELS_6_CA']    = Configuration::get('CUSTOMCARROUSELS_6_CA');
        $helper->fields_value['CUSTOMCARROUSELS_TITLE_6_ES']    = Configuration::get('CUSTOMCARROUSELS_TITLE_6_ES');
        $helper->fields_value['CUSTOMCARROUSELS_TITLE_6_CA']    = Configuration::get('CUSTOMCARROUSELS_TITLE_6_CA');
        $helper->fields_value['CUSTOMCARROUSELS_DESC_6_ES']    = Configuration::get('CUSTOMCARROUSELS_DESC_6_ES');
        $helper->fields_value['CUSTOMCARROUSELS_DESC_6_CA']    = Configuration::get('CUSTOMCARROUSELS_DESC_6_CA');
        $helper->fields_value['CUSTOMCARROUSELS_CATEGORY_6_ES']    = Configuration::get('CUSTOMCARROUSELS_CATEGORY_6_ES');
        $helper->fields_value['CUSTOMCARROUSELS_CATEGORY_6_CA']    = Configuration::get('CUSTOMCARROUSELS_CATEGORY_6_CA');

        $helper->fields_value['CUSTOMCARROUSELS_7_ES']    = Configuration::get('CUSTOMCARROUSELS_7_ES');
        $helper->fields_value['CUSTOMCARROUSELS_7_CA']    = Configuration::get('CUSTOMCARROUSELS_7_CA');
        $helper->fields_value['CUSTOMCARROUSELS_TITLE_7_ES']    = Configuration::get('CUSTOMCARROUSELS_TITLE_7_ES');
        $helper->fields_value['CUSTOMCARROUSELS_TITLE_7_CA']    = Configuration::get('CUSTOMCARROUSELS_TITLE_7_CA');
        $helper->fields_value['CUSTOMCARROUSELS_DESC_7_ES']    = Configuration::get('CUSTOMCARROUSELS_DESC_7_ES');
        $helper->fields_value['CUSTOMCARROUSELS_DESC_7_CA']    = Configuration::get('CUSTOMCARROUSELS_DESC_7_CA');
        $helper->fields_value['CUSTOMCARROUSELS_CATEGORY_7_ES']    = Configuration::get('CUSTOMCARROUSELS_CATEGORY_7_ES');
        $helper->fields_value['CUSTOMCARROUSELS_CATEGORY_7_CA']    = Configuration::get('CUSTOMCARROUSELS_CATEGORY_7_CA');

        $helper->fields_value['CUSTOMCARROUSELSSUSCRIPCION_1_ES']    = Configuration::get('CUSTOMCARROUSELSSUSCRIPCION_1_ES');
        $helper->fields_value['CUSTOMCARROUSELSSUSCRIPCION_1_CA']    = Configuration::get('CUSTOMCARROUSELSSUSCRIPCION_1_CA');
        $helper->fields_value['CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_ES']    = Configuration::get('CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_ES');
        $helper->fields_value['CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_CA']    = Configuration::get('CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_CA');
        $helper->fields_value['CUSTOMCARROUSELSSUSCRIPCION_DESC_1_ES']    = Configuration::get('CUSTOMCARROUSELSSUSCRIPCION_DESC_1_ES');
        $helper->fields_value['CUSTOMCARROUSELSSUSCRIPCION_DESC_1_CA']    = Configuration::get('CUSTOMCARROUSELSSUSCRIPCION_DESC_1_CA');
        $helper->fields_value['CUSTOMCARROUSELSSUSCRIPCION_CATEGORY_1_ES']    = Configuration::get('CUSTOMCARROUSELSSUSCRIPCION_CATEGORY_1_ES');
        $helper->fields_value['CUSTOMCARROUSELSSUSCRIPCION_CATEGORY_1_CA']    = Configuration::get('CUSTOMCARROUSELSSUSCRIPCION_CATEGORY_1_CA');

        return $helper->generateForm($fields_form);
    }
    public function install($delete_params = true)
    {

        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }
        if ($delete_params) {
            Configuration::updateValue('CUSTOMCARROUSELS_1_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_1_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_2_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_2_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_3_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_3_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_4_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_4_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_5_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_5_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_6_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_6_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_7_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_7_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELSSUSCRIPCION_7_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELSSUSCRIPCION_7_CA', "");
            
            Configuration::updateValue('CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_7_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_7_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_6_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_6_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_5_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_5_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_4_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_4_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_3_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_3_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_2_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_2_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_1_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_TITLE_1_ES', "");

            Configuration::updateValue('CUSTOMCARROUSELSSUSCRIPCION_DESC_1_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELSSUSCRIPCION_DESC_1_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_7_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_7_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_6_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_6_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_5_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_5_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_4_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_4_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_3_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_3_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_2_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_2_ES', "");
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_1_CA', "");
            Configuration::updateValue('CUSTOMCARROUSELS_DESC_1_ES', "");
        }


            if (!parent::install() ) {
                return false;
            }

    }

    public function uninstall($delete_params = true)
    {

        // Uninstall Module
        if (!parent::uninstall()) {
            return false;
        }
        if ($delete_params) {
            Configuration::deleteByName('CUSTOMCARROUSELS_1_ES');
            Configuration::deleteByName('CUSTOMCARROUSELS_1_CA');
            Configuration::deleteByName('CUSTOMCARROUSELS_2_ES');
            Configuration::deleteByName('CUSTOMCARROUSELS_2_CA');
            Configuration::deleteByName('CUSTOMCARROUSELS_3_ES');
            Configuration::deleteByName('CUSTOMCARROUSELS_3_CA');
            Configuration::deleteByName('CUSTOMCARROUSELS_4_ES');
            Configuration::deleteByName('CUSTOMCARROUSELS_4_CA');
            Configuration::deleteByName('CUSTOMCARROUSELS_5_ES');
            Configuration::deleteByName('CUSTOMCARROUSELS_5_CA');
            Configuration::deleteByName('CUSTOMCARROUSELS_6_ES');
            Configuration::deleteByName('CUSTOMCARROUSELS_6_CA');
            Configuration::deleteByName('CUSTOMCARROUSELS_7_ES');
            Configuration::deleteByName('CUSTOMCARROUSELS_7_CA');
            Configuration::deleteByName('CUSTOMCARROUSELSSUSCRIPCION_1_ES');
            Configuration::deleteByName('CUSTOMCARROUSELSSUSCRIPCION_1_CA');

            Configuration::deleteByName('CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_CA', "");
            Configuration::deleteByName('CUSTOMCARROUSELSSUSCRIPCION_TITLE_1_ES', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_TITLE_7_CA', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_TITLE_7_ES', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_TITLE_6_CA', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_TITLE_6_ES', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_TITLE_5_CA', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_TITLE_5_ES', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_TITLE_4_CA', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_TITLE_4_ES', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_TITLE_3_CA', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_TITLE_3_ES', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_TITLE_2_CA', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_TITLE_2_ES', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_TITLE_1_CA', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_TITLE_1_ES', "");

            Configuration::deleteByName('CUSTOMCARROUSELSSUSCRIPCION_DESC_1_CA', "");
            Configuration::deleteByName('CUSTOMCARROUSELSSUSCRIPCION_DESC_1_ES', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_DESC_7_CA', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_DESC_7_ES', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_DESC_6_CA', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_DESC_6_ES', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_DESC_5_CA', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_DESC_5_ES', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_DESC_4_CA', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_DESC_4_ES', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_DESC_3_CA', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_DESC_3_ES', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_DESC_2_CA', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_DESC_2_ES', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_DESC_1_CA', "");
            Configuration::deleteByName('CUSTOMCARROUSELS_DESC_1_ES', "");
            
        }
        return true;
    }

    public function generateAdminToken()
    {
        $cookie      = new Cookie('psAdmin');
        $id_employee = $cookie->__get('id_employee');
        $controller  = 'AdminOrders';
        $id_class    = Tab::getIdFromClassName($controller);
        return Tools::getAdminToken($controller . $id_class . $id_employee);
    }

}
