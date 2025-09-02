<?php

class customCartsOrder extends ObjectModel {

    public $id_order;

    public $id_order_detail;

    public $cesta;

    public $componente;

    public $alternativo;

    public $intercambiable;

    public $name;

    public $date_add;

    public $date_upd;

/**
* Définition des paramètres de la classe
*/
public static $definition = array(
'table' => 'customcarts_order_detail',
'primary' => 'id',
'multilang' => false,
'multilang_shop' => false,
'fields' => array(
    'id_order' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
    'cesta' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
    'componente' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
    'alternativo' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
    'intercambiable' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
    'name' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
),
);

/**
* Mapping de la classe avec le webservice
*
* @var type
*/
protected $webserviceParameters = [
'objectsNodeName' => 'customCartsOrder', //objectsNodeName doit être la valeur déclarée dans le hookAddWebserviceResources ( liste des entités )
'objectNodeName' => 'customCartOrder', // Détail d'une entité
'fields' => []
];



    public function insertProductOrder($id_order,$id_product,$product_attribute_id,$componente,$alternativo,$intercambiable,$name)
    {
        $date=date('Y-m-d H:i:s');

        $query = ' Insert into `' . _DB_PREFIX_ . 'customcarts_order_detail` (id_order,cesta,product_attribute_id,componente,alternativo,intercambiable,name,date_add,date_upd) values ("' . (int) $id_order.'","' . (int) $id_product.'","' . (int) $product_attribute_id.'","' . (int) $componente.'","' . (int) $alternativo.'","' . (int) $intercambiable.'","' .  $name.'","'. $date.'","'. $date.'")';

        $result = Db::getInstance()->execute($query);

        return $result;
    }

     public function getProductOrder($id_order,$id_product,$product_attribute_id)
{
    $query = '
            SELECT c.componente, c.intercambiable, c.`alternativo`,c.name,c.product_attribute_id 
            FROM `' . _DB_PREFIX_ . 'customcarts_order_detail` as c 
            WHERE id_order = "' . (int) $id_order.'" and cesta = "' . (int) $id_product.'" and product_attribute_id = "' . (int) $product_attribute_id.'"';

    $result = Db::getInstance()->executeS($query);

    return $result;
}

    public function getProductsOrder($id_order,$id_product,$product_attribute_id)
    {
        $query = '
            SELECT c.componente, c.intercambiable, c.`alternativo`,c.name 
            FROM `' . _DB_PREFIX_ . 'customcarts_order_detail` as c  
            WHERE c.id_order = "' . (int) $id_order.'" and c.cesta = "' . (int) $id_product.'" and product_attribute_id = "' . (int) $product_attribute_id.'"';


        $result = Db::getInstance()->executeS($query);

        foreach($result as &$value) {
            $objet_produit= new Product($value['componente']);
            $image = Image::getCover($value['componente']);
            // Initialize the link object
            $link = new Link;

            $value['image'] =Tools::getShopProtocol() . $link->getImageLink($objet_produit->link_rewrite[Context::getContext()->language->id], $image['id_image'], 'small_default');

        }
        return $result;

        return $result;
    }
}