<?php
if (!defined('_PS_VERSION_')) { exit; }

class PCatalogExtra extends Module
{
    public function __construct()
    {
        $this->name = 'pcatalogextra';
        $this->version = '1.1.1';
        $this->author = 'Pol Puig';
        $this->tab = 'administration';
        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = 'Catálogo Extra (columna adicional)';
        $this->description = 'Añade una columna extra en Catálogo > Productos (1.7.5.1).';
    }

    public function install()
    {
        return parent::install()
            && $this->installTab()
            && $this->registerHook('displayBackOfficeHeader');
    }

    public function uninstall()
    {
        return $this->uninstallTab() && parent::uninstall();
    }

    private function installTab()
    {
        $tab = new Tab();
        $tab->active = 0; // oculto
        $tab->class_name = 'AdminCatalogExtra';
        $tab->id_parent = (int)Tab::getIdFromClassName('AdminCatalog');
        if (!$tab->id_parent) {
            $tab->id_parent = 0;
        }
        $tab->module = $this->name;
        foreach (Language::getLanguages(false) as $lang) {
            $tab->name[$lang['id_lang']] = 'Catálogo Extra (ajax)';
        }
        return $tab->add();
    }

    private function uninstallTab()
    {
        $id = (int)Tab::getIdFromClassName('AdminCatalogExtra');
        if ($id) {
            $tab = new Tab($id);
            return $tab->delete();
        }
        return true;
    }

    public function hookDisplayBackOfficeHeader($params)
    {
        $this->context->controller->addJS($this->_path.'views/js/catalog-extra.js');
        Media::addJsDef([
            'pcatalogextra_ajax' => $this->context->link->getAdminLink('AdminCatalogExtra', true, [], ['ajax' => 1]),
            'pcatalogextra_token' => Tools::getAdminTokenLite('AdminCatalogExtra'),
        ]);
    }
}
