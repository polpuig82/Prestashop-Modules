<?php

class customCartsCart extends ObjectModel {

    public $id_cart;

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
    'id_cart' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
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
'objectsNodeName' => 'customCartsCarts', //objectsNodeName doit être la valeur déclarée dans le hookAddWebserviceResources ( liste des entités )
'objectNodeName' => 'customCartCart', // Détail d'une entité
'fields' => []
];

public function getProductosCart($id_cart)
{
    $query = '
            SELECT c.cesta,c.product_attribute_id,c.componente, c.intercambiable, c.`alternativo`,c.name 
            FROM `' . _DB_PREFIX_ . 'customcarts_cart_detail` as c  
            WHERE id_cart = "' . (int) $id_cart.'"';

    $result = Db::getInstance()->executeS($query);

    return $result;
}

public function getProductCart($id_cart,$id_product,$product_attribute_id)
{
    $query = '
            SELECT c.componente,c.product_attribute_id, c.intercambiable, c.`alternativo`,c.name 
            FROM `' . _DB_PREFIX_ . 'customcarts_cart_detail` as c 
            WHERE id_cart = "' . (int) $id_cart.'" and cesta = "' . (int) $id_product.'" and product_attribute_id = "' . (int) $product_attribute_id.'"';

    $result = Db::getInstance()->executeS($query);

    return $result;
}

public function exisProductCart($id_cart,$id_product,$product_attribute_id)
    {
        $query = '
            SELECT c.componente,c.product_attribute_id, c.intercambiable, c.`alternativo` 
            FROM `' . _DB_PREFIX_ . 'customcarts_cart_detail` as c 
            WHERE id_cart = "' . (int) $id_cart.'" and cesta = "' . (int) $id_product.'" and product_attribute_id = "' . (int) $product_attribute_id.'"';

        $result = Db::getInstance()->executeS($query);

        return $result;
    }

    public function insertProductCart($id_cart,$id_product,$product_attribute_id,$componente,$alternativo,$intercambiable,$name)
    {
        $date=date('Y-m-d H:i:s');

        $query = ' Insert into `' . _DB_PREFIX_ . 'customcarts_cart_detail` (id_cart,cesta,product_attribute_id,componente,alternativo,intercambiable,name,date_add,date_upd) values ("' . (int) $id_cart.'","' . (int) $id_product.'","'. (int) $product_attribute_id.'","' . (int) $componente.'","' . (int) $alternativo.'","' . (int) $intercambiable.'","' .  $name.'","'. $date.'","'. $date.'")';
           
        $result = Db::getInstance()->execute($query);

        return $result;
    }

    public function deleteProductCart($id_cart,$id_product,$product_attribute_id)
    {


        $query = ' Delete from `' . _DB_PREFIX_ . 'customcarts_cart_detail`  where id_cart = "' . (int) $id_cart.'" and cesta = "' . (int) $id_product.'" and product_attribute_id = "' . (int) $product_attribute_id.'"';

        $result = Db::getInstance()->execute($query);

        return $result;
    }

}