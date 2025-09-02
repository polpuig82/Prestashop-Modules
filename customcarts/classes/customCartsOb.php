<?php

class customCartsOb extends ObjectModel {


public $cesta;

public $componente;

public $alternativo;

public $intercambiable;

public $cantidad;

public $unidad_medida;

public $unidades_aprox;

public $origen;

public $orden;


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
'cantidad'=> array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
'unidad_medida'=> array('type' => self::TYPE_STRING, 'validate' => 'isString'),
'unidades_aprox'=> array('type' => self::TYPE_STRING, 'validate' => 'isString'),
'origen'=> array('type' => self::TYPE_STRING, 'validate' => 'isString'),
'orden'=> array('type' => self::TYPE_INT, 'validate' => 'isInt'),


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

    public function getProductosCestaAlternativa($id_product,$id_lang,$id_attribute = 0)
    {
        $query = '
            SELECT t.componente, t.intercambiable, t.`alternativo`, t.`cantidad`,t.`unidad_medida`,t.`unidades_aprox`,t.`origen`,t.`orden`,l.name 
            FROM `' . _DB_PREFIX_ . 'customcarts_table` as t,`' . _DB_PREFIX_ . 'product` as p,`' . _DB_PREFIX_ . 'product_lang`  as l 
            WHERE cesta = "' . (int) $id_product.'"  and t.componente=p.id_product and p.id_product=l.id_product and alternativo=1 and l.id_lang="'.$id_lang.'"
            ORDER BY t.orden ASC';

        $result = Db::getInstance()->executeS($query);

        foreach($result as &$value) {
            $objet_produit= new Product($value['componente']);
            $image = Image::getCover($value['componente']);
            // Initialize the link object
            $link = new Link;

            $value['image'] =Tools::getShopProtocol() . $link->getImageLink($objet_produit->link_rewrite[Context::getContext()->language->id], $image['id_image'], 'small_default');
            /**
             * MOD PABLO: Obtengo precio especifico del producto alternativo
            */
            $context = Context::getContext();
            $shop = $context->shop;
            $currency = $context->currency;
            $country = $context->country;
            $objParentProduct = new Product($id_product);

            //Si no se recibe un $id_attribute, se comprueba por $_POST / $_GET, y si no, se obtiene de la combinación por defecto
            if(intval($id_attribute) == 0) {
                if(Tools::getIsset("id_product_attribute") && intval(Tools::getValue("id_product_attribute")) > 0) {
                    $prdAttribute = new Combination(intval(Tools::getValue("id_product_attribute")));
                } else {
                    $prdAttribute = new Combination($objParentProduct->getDefaultIdProductAttribute());
                }
                $id_attribute = $prdAttribute->getWsProductOptionValues()[0]['id'];
            }

            $sql = 'SELECT pac.id_product_attribute
                    FROM ' . _DB_PREFIX_ . 'product_attribute_combination pac
                    INNER JOIN ' . _DB_PREFIX_ . 'product_attribute pa ON pac.id_product_attribute = pa.id_product_attribute
                    WHERE pac.id_attribute=' . (int) $id_attribute . ' AND pa.id_product=' . (int) $objet_produit->id;
            $id_product_attribute = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
            $specific_price_producto_alternativo = SpecificPrice::getSpecificPrice($objet_produit->id, $shop->id, $currency->id, $country->id, 1, 1, $id_product_attribute);

            $precio_producto_alternativo = Product::getPriceStatic($objet_produit->id, true, $id_product_attribute, 6, null, false, true, 1, false, null, null, null, $specific_price_producto_alternativo);

            $value['variacion'] = $precio_producto_alternativo;

        }
        return $result;
    }

    public function getProductosCestaDefinida($id_product,$id_lang,$id_attribute=0)
    {
        $query = '
            SELECT t.componente, t.intercambiable, t.`alternativo`, t.`cantidad`,t.`unidad_medida`,t.`unidades_aprox`,t.`origen`,t.`orden`, l.name 
            FROM `' . _DB_PREFIX_ . 'customcarts_table` as t,`' . _DB_PREFIX_ . 'product` as p,`' . _DB_PREFIX_ . 'product_lang`  as l 
            WHERE cesta = "' . (int) $id_product.'"  and t.componente=p.id_product and p.id_product=l.id_product and alternativo=0 and l.id_lang="'.$id_lang.'"
            ORDER BY t.orden ASC';
        $result = Db::getInstance()->executeS($query);

        foreach($result as &$value) {
            $objet_produit= new Product($value['componente']);
            $image = Image::getCover($value['componente']);
            // Initialize the link object
            $link = new Link;

            $value['image'] =Tools::getShopProtocol() . $link->getImageLink($objet_produit->link_rewrite[Context::getContext()->language->id], $image['id_image'], 'small_default');
            /**
             * MOD PABLO: Obtengo el precio del producto "original" mostrado
             */
            $context = Context::getContext();
            $shop = $context->shop;
            $currency = $context->currency;
            $country = $context->country;
            $objParentProduct = new Product($id_product);


            //Si no se recibe un $id_attribute, se comprueba por $_POST / $_GET, y si no, se obtiene de la combinación por defecto
            if(intval($id_attribute) == 0) {
                if(Tools::getIsset("id_product_attribute") && intval(Tools::getValue("id_product_attribute")) > 0) {
                    $prdAttribute = new Combination(intval(Tools::getValue("id_product_attribute")));
                } else {
                    $prdAttribute = new Combination($objParentProduct->getDefaultIdProductAttribute());
                }
                $id_attribute = $prdAttribute->getWsProductOptionValues()[0]['id'];
            }

            $sql = 'SELECT pac.id_product_attribute
                    FROM ' . _DB_PREFIX_ . 'product_attribute_combination pac
                    INNER JOIN ' . _DB_PREFIX_ . 'product_attribute pa ON pac.id_product_attribute = pa.id_product_attribute
                    WHERE pac.id_attribute=' . (int) $id_attribute . ' AND pa.id_product=' . (int) $objet_produit->id;
            $id_product_attribute = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

            $specific_price_producto_definido = SpecificPrice::getSpecificPrice($objet_produit->id, $shop->id, $currency->id, $country->id, 1, 1, $id_product_attribute);

            $precio_producto_definido = Product::getPriceStatic($objet_produit->id, true, $id_product_attribute, 6, null, false, true, 1, false, null, null, null, $specific_price_producto_definido);

            $value['variacion'] = $precio_producto_definido;
        }

        return $result;
    }

    public function getNumProductosCestaDefinida($id_product,$id_lang)
    {
        $query = '
            SELECT t.componente, t.intercambiable, t.`alternativo`, t.`cantidad`,t.`unidad_medida`,t.`unidades_aprox`,t.`origen`,t.`orden`, l.name 
            FROM `' . _DB_PREFIX_ . 'customcarts_table` as t,`' . _DB_PREFIX_ . 'product` as p,`' . _DB_PREFIX_ . 'product_lang`  as l 
            WHERE cesta = "' . (int) $id_product.'"  and t.componente=p.id_product and p.id_product=l.id_product  and t.alternativo=0 and l.id_lang="'.$id_lang.'"
            ORDER BY t.orden ASC';
        $result = Db::getInstance()->executeS($query);

        return $result;
    }

    public function getProductoCestaDefinida($id_product,$componente,$id_lang)
    {
        $query = '
            SELECT t.componente, t.intercambiable, t.`alternativo`, t.`cantidad`,t.`unidad_medida`,t.`unidades_aprox`,t.`origen`,t.`orden`, l.name 
            FROM `' . _DB_PREFIX_ . 'customcarts_table` as t,`' . _DB_PREFIX_ . 'product` as p,`' . _DB_PREFIX_ . 'product_lang`  as l 
            WHERE cesta = "' . (int) $id_product.'" and componente = "' . (int) $componente.'"  and t.componente=p.id_product and p.id_product=l.id_product and l.id_lang="'.$id_lang.'"
            ORDER BY t.orden ASC';



        $result = Db::getInstance()->executeS($query);
        if($result)
        return $result[0];
        else
            $result;
    }



}