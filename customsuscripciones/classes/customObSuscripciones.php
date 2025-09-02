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
            // $result['active']=$objet_produit->active;
            //$result['id_category'] =  $objet_produit->id_category_default;

            if(!isset($result['grossUnitPrice'])){

                    $result['grossUnitPrice'] =number_format((float) $objet_produit->price, 2, '.', '');
                        //$result['grossUnitPrice'] = number_format((float) $objet_produit->getPrice(Product::$_taxCalculationMethod == PS_TAX_INC), 2, '.', '');
                        // Product::getPriceStatic($idProduct); Arreglar Sacar Precio de un Producto

                        //19/07/2022 añadir cambio verificado

                         //sacar precio en partes

                    $groupid=Customer::getDefaultGroupId(Context::getContext()->customer->id);

            if(!SpecificPrice::getSpecificPrice($objet_produit->id,Context::getContext()->shop->id,Context::getContext()->currency->id,Context::getContext()->country->id,$groupid,1))

                $value['grossUnitPrice'] =number_format((float) $objet_produit->price, 2, '.', '');
            else
            {
                $value['grossUnitPrice']=number_format((float) SpecificPrice::getSpecificPrice($objet_produit->id,Context::getContext()->shop->id,Context::getContext()->currency->id,Context::getContext()->country->id,$groupid,1)['price'], 2, '.', '');
            }

            }

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
            $value['active'] = $objet_produit->active;

            //19/07/2022 añadir cambio verificado
                 //sacar precio en partes

            $groupid=Customer::getDefaultGroupId(Context::getContext()->customer->id);

            if(!SpecificPrice::getSpecificPrice($objet_produit->id,Context::getContext()->shop->id,Context::getContext()->currency->id,Context::getContext()->country->id,$groupid,1))

                $value['grossUnitPrice'] =number_format((float) $objet_produit->price, 2, '.', '');
            else
            {
                $value['grossUnitPrice']=number_format((float) SpecificPrice::getSpecificPrice($objet_produit->id,Context::getContext()->shop->id,Context::getContext()->currency->id,Context::getContext()->country->id,$groupid,1)['price'], 2, '.', '');
            }


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
            $arr['grossUnitPrice'] = number_format((float) $objet_produit->price, 2, '.', '');

            array_push($resultados,$arr);
        }

        return $resultados;
    }

    public function getProductosRecomendados1($id_lang)
    {



          if($id_lang==1){
            $carrousel = Configuration::get('CUSTOMCARROUSELS_1_ES');
          } else {
            $carrousel = Configuration::get('CUSTOMCARROUSELS_1_CA');
          }


        $result=explode(",", $carrousel);
        if ((count($result) > 0) and $result[0] > 0){
             //Acople
            $pr = array();
            foreach ($result as $value) {
                $nodo['productId'] = $value;
                array_push($pr,$nodo);
            }
        $prodactivelist = customObSuscripciones::getProductosContent($pr,$id_lang);
        $productosrecomendados = array();


        foreach($prodactivelist as $set){
            if($set['active'] == 1){
                array_push($productosrecomendados,$set);
              }

          }

    }
        return $productosrecomendados;
    }



    public function getProductosRecomendados2($id_lang)
    {
        $productosrecomendados = array();

        if ($id_lang == 1) {
            $carrousel = Configuration::get('CUSTOMCARROUSELS_2_ES');
        } else {
            $carrousel = Configuration::get('CUSTOMCARROUSELS_2_CA');
        }

        $result = explode(",", $carrousel);
        if ((count($result) > 0) and $result[0] > 0) {
            //Acople
            $pr = array();
            foreach ($result as $value) {
                $nodo['productId'] = $value;
                array_push($pr, $nodo);
            }
            $prodactivelist = customObSuscripciones::getProductosContent($pr, $id_lang);
            $productosrecomendados = array();

            foreach($prodactivelist as $set){

                if($set['active'] == 1){
                        array_push($productosrecomendados,$set);

                    }

                }

            }




        return $productosrecomendados;
    }


    public function getProductosRecomendados3($id_lang)
    {
        $productosrecomendados = array();

        if ($id_lang == 1) {
            $carrousel = Configuration::get('CUSTOMCARROUSELS_3_ES');
        } else {
            $carrousel = Configuration::get('CUSTOMCARROUSELS_3_CA');
        }

        $result = explode(",", $carrousel);
        if ((count($result) > 0) and $result[0] > 0) {
            //Acople
            $pr = array();
            foreach ($result as $value) {
                $nodo['productId'] = $value;
                array_push($pr, $nodo);
            }
            $prodactivelist = customObSuscripciones::getProductosContent($pr, $id_lang);
            $productosrecomendados = array();

            foreach($prodactivelist as $set){

                if($set['active'] == 1){
                        array_push($productosrecomendados,$set);

                    }

                }

            }




        return $productosrecomendados;
    }

      public function getProductosRecomendados4($id_lang)
    {
       /* $query = '
            SELECT id_product as productId
            FROM `' . _DB_PREFIX_ . 'product` p
            WHERE p.active = 1 ORDER BY RAND() limit 10';
        $result = Db::getInstance()->executeS($query);*/

        $productosrecomendados=array();

          if($id_lang==1)
            $carrousel = Configuration::get('CUSTOMCARROUSELS_4_ES');
        else
            $carrousel = Configuration::get('CUSTOMCARROUSELS_4_CA');
        $result=explode(",", $carrousel);
        if((count($result)>0) and $result[0]>0){
             //Acople
            $pr=array();
            foreach ($result as $value) {
                $nodo['productId']=$value;
                array_push($pr,$nodo);
            }

            $productosrecomendados=customObSuscripciones::getProductosContent($pr,$id_lang);

    }
        return $productosrecomendados;
    }

    public function getProductosSuscripcion1($id_lang)
    {



          if($id_lang==1){
            $carrousel = Configuration::get('CUSTOMCARROUSELSSUSCRIPCION_1_ES');
          } else {
            $carrousel = Configuration::get('CUSTOMCARROUSELSSUSCRIPCION_1_CA');
          }


        $result=explode(",", $carrousel);
        if ((count($result) > 0) and $result[0] > 0){
             //Acople
            $pr = array();
            foreach ($result as $value) {
                $nodo['productId'] = $value;
                array_push($pr,$nodo);
            }
        $prodactivelist = customObSuscripciones::getProductosContent($pr,$id_lang);
        $productosrecomendados = array();


        foreach($prodactivelist as $set){
            if($set['active'] == 1){
                array_push($productosrecomendados,$set);
              }

          }

    }
        return $productosrecomendados;
    }



}
