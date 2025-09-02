<?php

class customObSuscripciones extends ObjectModel {


public $cesta;

public $componente;


    public function getProducto($idProduct,$id_lang)
    {

            $objet_produit= new Product($idProduct);
            $image = Image::getCover($idProduct);
            // Initialize the link object
            $link = new Link;

            $result['image'] =Tools::getShopProtocol() . $link->getImageLink($objet_produit->link_rewrite[Context::getContext()->language->id], $image['id_image'], 'small_default');
            $result['name']=$objet_produit->name[$id_lang];
            $result['active']=$objet_produit->active;

        return $result;
    }

    public function getProductosContent($result,$id_lang)
    {


        foreach($result as &$value) {
            $objet_produit= new Product($value['productId'],$id_lang);
            $image = Image::getCover($value['productId']);
            // Initialize the link object
            $link = new Link;

            $value['image'] =Tools::getShopProtocol() . $link->getImageLink($objet_produit->link_rewrite[Context::getContext()->language->id], $image['id_image'], 'small_default');
            $value['name']=$objet_produit->name[$id_lang];
        }

        return $result;
    }

    public function getProductosAlternativos($result,$id_lang)
    {
    $resultados=array();

        foreach($result as $value) {
            $value=(int) $value;
            $arr=array();
            $objet_produit= new Product($value,$id_lang);
            $image = Image::getCover($value);
            // Initialize the link object
            $link = new Link;
            $arr['productId']=$value;
            $arr['image'] =Tools::getShopProtocol() . $link->getImageLink($objet_produit->link_rewrite[Context::getContext()->language->id], $image['id_image'], 'small_default');
            $arr['name']=$objet_produit->name[$id_lang];

            array_push($resultados,$arr);
        }

        return $resultados;
    }

    public function getProductosRecomendados1($id_lang)
    {
        $query = '
            SELECT id_product as productId  
            FROM `' . _DB_PREFIX_ . 'product` p 
            WHERE p.active = 1 ORDER BY RAND() limit 10';
        $result = Db::getInstance()->executeS($query);

        $productosrecomendados=array();
        if($result)
        {
            $productosrecomendados=CustomOb::getProductosContent($result,$id_lang);
        }
        return $productosrecomendados;
    }


    public function getProductosRecomendados2($id_lang)
    {
        $query = '
            SELECT id_product as productId  
            FROM `' . _DB_PREFIX_ . 'product` p 
            WHERE p.active = 1 ORDER BY RAND() limit 10';
        $result = Db::getInstance()->executeS($query);

        $productosrecomendados=array();
        if($result)
        {
            $productosrecomendados=CustomOb::getProductosContent($result,$id_lang);
        }
        return $productosrecomendados;
    }

    public function getProductosRecomendados3($id_lang)
    {
        $query = '
            SELECT id_product as productId  
            FROM `' . _DB_PREFIX_ . 'product` p 
            WHERE p.active = 1 ORDER BY RAND() limit 10';
        $result = Db::getInstance()->executeS($query);

        $productosrecomendados=array();
        if($result)
        {
            $productosrecomendados=CustomOb::getProductosContent($result,$id_lang);
        }
        return $productosrecomendados;
    }



}