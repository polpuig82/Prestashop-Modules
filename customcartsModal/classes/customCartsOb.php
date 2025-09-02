<?php

class customCartsOb extends ObjectModel {


public $cesta;

public $componente;

public $alternativo;

public $intercambiable;

/**
* Définition des paramètres de la classe
*/
public static $definition = array(
'table' => 'customcarts_table',
'primary' => 'id',
'multilang' => false,
'multilang_shop' => false,
'fields' => array(
'cesta' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
'componente' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
'alternativo' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
    'intercambiable' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
),
);

/**
* Mapping de la classe avec le webservice
*
* @var type
*/
protected $webserviceParameters = [
'objectsNodeName' => 'customcartsobs', //objectsNodeName doit être la valeur déclarée dans le hookAddWebserviceResources ( liste des entités )
'objectNodeName' => 'customcartsob', // Détail d'une entité
'fields' => []
];

    public function getProductosCestaAlternativa($id_product,$id_lang)
    {
        $query = '
            SELECT t.componente, t.intercambiable, t.`alternativo`,l.name 
            FROM `' . _DB_PREFIX_ . 'customcarts_table` as t,`' . _DB_PREFIX_ . 'product` as p,`' . _DB_PREFIX_ . 'product_lang`  as l 
            WHERE cesta = "' . (int) $id_product.'"  and t.componente=p.id_product and p.id_product=l.id_product and alternativo=1 and l.id_lang="'.$id_lang.'"';

        $result = Db::getInstance()->executeS($query);

        foreach($result as &$value) {
            $objet_produit= new Product($value['componente']);
            $image = Image::getCover($value['componente']);
            // Initialize the link object
            $link = new Link;

            $value['image'] =Tools::getShopProtocol() . $link->getImageLink($objet_produit->link_rewrite[Context::getContext()->language->id], $image['id_image'], 'small_default');

        }
        return $result;
    }

    public function getProductosCestaDefinida($id_product,$id_lang)
    {
        $query = '
            SELECT t.componente, t.intercambiable, t.`alternativo`,l.name 
            FROM `' . _DB_PREFIX_ . 'customcarts_table` as t,`' . _DB_PREFIX_ . 'product` as p,`' . _DB_PREFIX_ . 'product_lang`  as l 
            WHERE cesta = "' . (int) $id_product.'"  and t.componente=p.id_product and p.id_product=l.id_product and alternativo=0 and l.id_lang="'.$id_lang.'"';
        $result = Db::getInstance()->executeS($query);

        foreach($result as &$value) {
            $objet_produit= new Product($value['componente']);
            $image = Image::getCover($value['componente']);
            // Initialize the link object
            $link = new Link;

            $value['image'] =Tools::getShopProtocol() . $link->getImageLink($objet_produit->link_rewrite[Context::getContext()->language->id], $image['id_image'], 'small_default');

        }

        return $result;
    }

    public function getNumProductosCestaDefinida($id_product,$id_lang)
    {
        $query = '
            SELECT t.componente, t.intercambiable, t.`alternativo`,l.name 
            FROM `' . _DB_PREFIX_ . 'customcarts_table` as t,`' . _DB_PREFIX_ . 'product` as p,`' . _DB_PREFIX_ . 'product_lang`  as l 
            WHERE cesta = "' . (int) $id_product.'"  and t.componente=p.id_product and p.id_product=l.id_product  and t.alternativo=0 and l.id_lang="'.$id_lang.'"';
        $result = Db::getInstance()->executeS($query);

        return $result;
    }

    public function getProductoCestaDefinida($id_product,$componente,$id_lang)
    {
        $query = '
            SELECT t.componente, t.intercambiable, t.`alternativo`,l.name 
            FROM `' . _DB_PREFIX_ . 'customcarts_table` as t,`' . _DB_PREFIX_ . 'product` as p,`' . _DB_PREFIX_ . 'product_lang`  as l 
            WHERE cesta = "' . (int) $id_product.'" and componente = "' . (int) $componente.'"  and t.componente=p.id_product and p.id_product=l.id_product and l.id_lang="'.$id_lang.'"';



        $result = Db::getInstance()->executeS($query);
        if($result)
        return $result[0];
        else
            $result;
    }



}