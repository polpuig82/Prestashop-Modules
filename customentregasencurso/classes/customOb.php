<?php

class customOb extends ObjectModel
{

    public $cesta;

    public $componente;

    public static $pedidosencurso;

    private static $isPedidosEnCursoSet = false;

    private static $totalAmount = 0;
    private static $cashBack;


    public static function setPedidosEnCurso($pedidosencurso)
    {
        // Si ya se ha ejecutado la función, no hacer nada
        if (self::$isPedidosEnCursoSet) {
            return;
        }
    
        $context = Context::getContext();
        $id_customer = $context->customer->id;        
        $params = array("clientId" => $id_customer, "detail" => 1);
        require_once _PS_MODULE_DIR_.'customcashback/customcashback.php';
        self::$cashBack = CustomCashBack::wsOBCall($params);
    
        // Bandera para indicar si se ha aplicado el descuento al primer pedido
        $appliedToFirst = false;
        if (isset(self::$cashBack['error']) && self::$cashBack['error']) {
            // Handle the case when 'error' is defined and true
        } else {
            // Your existing code for the "else" block
            foreach ($pedidosencurso as $pedido) {
                //var_dump($pedido);
                if ($pedido->status !== 'CO') {
                    if (!$appliedToFirst) {
                        self::$totalAmount = $pedido->totalAmount * self::$cashBack['maxPercentage'] / 100;
                        $appliedToFirst = true;
                    }
                    // Do something with the other ongoing orders if necessary
                }
            }
        }
        
        self::$pedidosencurso = $pedidosencurso;
    
        // Asignar valor a la variable estática
        self::$isPedidosEnCursoSet = true;
    }
    
    
    
    public function getProducto($result, $id_lang)
    {
       
        
          $objet_produit = new Product($result['productId']);
          $image = Image::getCover($result['productId']);
          // Initialize the link object
          $link = new Link;

          $result['image'] = Tools::getShopProtocol() . $link->getImageLink($objet_produit->link_rewrite[Context::getContext()->language->id], $image['id_image'], 'small_default');
          $result['name'] = $objet_produit->name[$id_lang];
        //$result['active'] = $objet_produit->active;
          $result['id_category'] =  $objet_produit->id_category_default;
            // var_dump(self::$cashBack['balance']);

          
          if(!isset($result['grossUnitPrice'])){
            if ($result['productId'] == self::$cashBack['cashbackProduct']) {
                
                if (self::$cashBack['balance'] >= abs(self::$totalAmount)) {
                    $result['grossUnitPrice'] = -self::$totalAmount;
                } else {
                    // No hay suficiente saldo, ajustar el valor de self::$totalAmount
                    $result['grossUnitPrice'] = -self::$cashBack['balance'];
                    self::$totalAmount -= abs(self::$cashBack['balance']);
                }
            
            } else {
                $result['grossUnitPrice'] = number_format((float) Product::getPriceStatic($result['productId']), 2, '.', '');
            }
            
           

          $groupid=Customer::getDefaultGroupId(Context::getContext()->customer->id);

         //sacar precio en partes
              if(!SpecificPrice::getSpecificPrice($objet_produit->id,Context::getContext()->shop->id,Context::getContext()->currency->id,Context::getContext()->country->id,$groupid,1))

                  $value['grossUnitPrice'] =number_format((float) $objet_produit->price, 2, '.', '');
              else
              {
                  $value['grossUnitPrice'] = number_format((float) Product::getPriceStatic($result['productId']), 2, '.', '');
              }


            }



          return $result;
      }

    public static function getProductosContent($result, $id_lang)
    {

        foreach ($result as &$value) {
            $object_product = new Product($value['productId']);
            $image = Image::getCover($value['productId']);
            // Initialize the link object
            $link = new Link;

            $value['image'] = Tools::getShopProtocol() . $link->getImageLink($object_product->link_rewrite[Context::getContext()->language->id], $image['id_image'], 'small_default');
            $value['name'] = $object_product->name[$id_lang];
            $value['active'] = $object_product->active;
            //$value['grossUnitPrice'] = number_format((float) $object_product->price, 2, '.', '');
            //cambio clearis 19/07/2022 sustituido por linea más abajo
            //$value['grossUnitPrice'] = number_format((float) $object_product->price, 2, '.', '');

            $groupid = Customer::getDefaultGroupId(Context::getContext()->customer->id);

            //sacar precio en partes
            if (!SpecificPrice::getSpecificPrice($object_product->id, Context::getContext()->shop->id, Context::getContext()->currency->id, Context::getContext()->country->id, $groupid, 1)) {
                $value['grossUnitPrice'] = number_format((float) $object_product->price, 2, '.', '');
            } else {
               // $value['grossUnitPrice'] = number_format((float) SpecificPrice::getSpecificPrice($object_product->id, Context::getContext()->shop->id, Context::getContext()->currency->id, Context::getContext()->country->id, $groupid, 1)['price'], 2, '.', '');
               $value['grossUnitPrice'] = Product::getPriceStatic($value['productId'],false,null,2);

            }

            //number_format((float) $object_product->getPrice(Product::$_taxCalculationMethod == PS_TAX_INC), 2, '.', '');

            //
        }

        return $result;
    }

    public function getProductosAlternativos($result, $id_lang)
    {
        $resultados = array();

        foreach ($result as $value) {

            if(isset($value["productId"])) {

                $productId = (int) $value["productId"];
                $arr = array();
    
                $object_product = new Product($productId);
                $image = Image::getCover($productId);
                // Initialize the link object
                $link = new Link;
                $arr['productId'] = $productId;
                $arr['image'] = Tools::getShopProtocol() . $link->getImageLink($object_product->link_rewrite[Context::getContext()->language->id], $image['id_image'], 'small_default');
                $arr['name'] = $object_product->name[$id_lang];
                $arr['grossUnitPrice'] = number_format((float) $object_product->price, 2, '.', '');
    
                //Añadimos a cada ítem del array los nuevos parámetros "cantidad" y "UM"

                $arr['cantidad'] = $value["cantidad"];
                $arr['UM'] = $value["UM"];
                if(isset($value["aproxUnits"])) {
                    $arr['aproxUnits'] = $value["aproxUnits"];
                }

                //Añadimos a cada ítem del array el  nuevo parámetro "origin"

                if(isset($value["origin"])) {
                    $arr['origin'] = $value["origin"];
                }

                //number_format((float) $object_product->getPrice(Product::$_taxCalculationMethod == PS_TAX_INC), 2, '.', '');
    
                array_push($resultados, $arr);

            }

        }
        return $resultados;
    }

    
    public function getProductosRecomendados1($id_lang)
    {
        if ($id_lang == 1) {
            $carrousel = Configuration::get('CUSTOMCARROUSELS_1_ES');
        } else {
            $carrousel = Configuration::get('CUSTOMCARROUSELS_1_CA');
        }

        $result = explode(",", $carrousel);
        if ((count($result) > 0) and $result[0] > 0) {
            //Acople
            $pr = array();
            foreach ($result as $value) {
                $nodo['productId'] = $value;
                array_push($pr, $nodo);
            }
            $prodactivelist = CustomOb::getProductosContent($pr, $id_lang);
            
            $productosrecomendados = [];

            //RM #56870 Quitar productos con restricción de frío en carruseles según cp del cliente
            if (is_array(self::$pedidosencurso) && !empty(self::$pedidosencurso)) {

            foreach (self::$pedidosencurso as $pedido) {
                $codigoPostal = $pedido->shippingAddress->postcode;
                $productosParaEstePedido = [];

                foreach($prodactivelist as $set){
                    $idP = $set['productId'];
                
                    // Comprobar si el producto está restringido para el código postal
                    $sql = "SELECT COUNT(*) AS count
                    FROM " . _DB_PREFIX_ . "products_cp_code
                    WHERE id_product = " . (int)$idP . "
                    AND cp_code = '" . pSQL($codigoPostal) . "'";

                    $restricted = Db::getInstance()->getValue($sql);

                    //var_dump($restricted);

                    
                    if($restricted == 0 && $set['active'] == 1){
                        array_push($productosParaEstePedido, $set);
                    }
                    
                }

                // Asignar los productos recomendados para este pedido en el arreglo principal
                $productosrecomendados[$pedido->obId] = $productosParaEstePedido;
                //var_dump($productosrecomendados[$pedido->id]);
                //var_dump($pedido->obId);

                //END RM #56870
            }

        }
    } else {
        // Manejar el caso en que no haya pedidos en curso
        echo "No hay pedidos en curso.";
    }
        //var_dump($productosParaEstePedido);




        return $productosrecomendados;
    }

    public function getProductosRecomendados2($id_lang)
    {

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
            $prodactivelist = CustomOb::getProductosContent($pr, $id_lang);
            $productosrecomendados = [];

            //RM #56870 Quitar productos con restricción de frío en carruseles según cp del cliente
            if (is_array(self::$pedidosencurso) && !empty(self::$pedidosencurso)) {

            foreach (self::$pedidosencurso as $pedido) {
                //var_dump($pedido);
                $codigoPostal = $pedido->shippingAddress->postcode;
                $productosParaEstePedido = [];

                foreach($prodactivelist as $set){
                    $idP = $set['productId'];
                
                    // Comprobar si el producto está restringido para el código postal
                    $sql = "SELECT COUNT(*) AS count
                    FROM " . _DB_PREFIX_ . "products_cp_code
                    WHERE id_product = " . (int)$idP . "
                    AND cp_code = '" . pSQL($codigoPostal) . "'";

                    $restricted = Db::getInstance()->getValue($sql);

                    //var_dump($restricted);

                    
                    if($restricted == 0 && $set['active'] == 1){
                        array_push($productosParaEstePedido, $set);
                    }
                    
                }
                
                // Asignar los productos recomendados para este pedido en el arreglo principal
                $productosrecomendados[$pedido->obId] = $productosParaEstePedido;
                
                //END RM #56870
            }

            }} else {
                // Manejar el caso en que no haya pedidos en curso
                echo "No hay pedidos en curso.";
            }



        return $productosrecomendados;
    }

    public function getProductosRecomendados3($id_lang)
    {

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
            $prodactivelist = CustomOb::getProductosContent($pr, $id_lang);
            $productosrecomendados = [];

            //RM #56870 Quitar productos con restricción de frío en carruseles según cp del cliente
            if (is_array(self::$pedidosencurso) && !empty(self::$pedidosencurso)) {

            foreach (self::$pedidosencurso as $pedido) {
                $codigoPostal = $pedido->shippingAddress->postcode;
                $productosParaEstePedido = [];

                foreach($prodactivelist as $set){
                    $idP = $set['productId'];
                
                    // Comprobar si el producto está restringido para el código postal
                    $sql = "SELECT COUNT(*) AS count
                    FROM " . _DB_PREFIX_ . "products_cp_code
                    WHERE id_product = " . (int)$idP . "
                    AND cp_code = '" . pSQL($codigoPostal) . "'";

                    $restricted = Db::getInstance()->getValue($sql);

                    //var_dump($restricted);

                    
                    if($restricted == 0 && $set['active'] == 1){
                        array_push($productosParaEstePedido, $set);
                    }
                    
                }

                // Asignar los productos recomendados para este pedido en el arreglo principal
                $productosrecomendados[$pedido->obId] = $productosParaEstePedido;
                
                //END RM #56870
            }

            }} else {
                // Manejar el caso en que no haya pedidos en curso
                echo "No hay pedidos en curso.";
            }




        return $productosrecomendados;
    }

    public function getProductosRecomendados4($id_lang)
    {

        if ($id_lang == 1) {
            $carrousel = Configuration::get('CUSTOMCARROUSELS_4_ES');
        } else {
            $carrousel = Configuration::get('CUSTOMCARROUSELS_4_CA');
        }

        $result = explode(",", $carrousel);
        if ((count($result) > 0) and $result[0] > 0) {
            //Acople
            $pr = array();
            foreach ($result as $value) {
                $nodo['productId'] = $value;
                array_push($pr, $nodo);
            }
            $prodactivelist = CustomOb::getProductosContent($pr, $id_lang);
            $productosrecomendados = [];

            //RM #56870 Quitar productos con restricción de frío en carruseles según cp del cliente
            if (is_array(self::$pedidosencurso) && !empty(self::$pedidosencurso)) {

            foreach (self::$pedidosencurso as $pedido) {
                $codigoPostal = $pedido->shippingAddress->postcode;
                $productosParaEstePedido = [];

                foreach($prodactivelist as $set){
                    $idP = $set['productId'];
                
                    // Comprobar si el producto está restringido para el código postal
                    $sql = "SELECT COUNT(*) AS count
                    FROM " . _DB_PREFIX_ . "products_cp_code
                    WHERE id_product = " . (int)$idP . "
                    AND cp_code = '" . pSQL($codigoPostal) . "'";

                    $restricted = Db::getInstance()->getValue($sql);

                    //var_dump($restricted);

                    
                    if($restricted == 0 && $set['active'] == 1){
                        array_push($productosParaEstePedido, $set);
                    }
                    
                }

                // Asignar los productos recomendados para este pedido en el arreglo principal
                $productosrecomendados[$pedido->obId] = $productosParaEstePedido;
                
                //END RM #56870
            }

        }} else {
            // Manejar el caso en que no haya pedidos en curso
            echo "No hay pedidos en curso.";
        }
        return $productosrecomendados;
    }

    public function getProductosRecomendados5($id_lang)
    {

        if ($id_lang == 1) {
            $carrousel = Configuration::get('CUSTOMCARROUSELS_5_ES');
        } else {
            $carrousel = Configuration::get('CUSTOMCARROUSELS_5_CA');
        }

        $result = explode(",", $carrousel);
        if ((count($result) > 0) and $result[0] > 0) {
            //Acople
            $pr = array();
            foreach ($result as $value) {
                $nodo['productId'] = $value;
                array_push($pr, $nodo);
            }
            $prodactivelist = CustomOb::getProductosContent($pr, $id_lang);
            $productosrecomendados = [];

            //RM #56870 Quitar productos con restricción de frío en carruseles según cp del cliente
            if (is_array(self::$pedidosencurso) && !empty(self::$pedidosencurso)) {

            foreach (self::$pedidosencurso as $pedido) {
                $codigoPostal = $pedido->shippingAddress->postcode;
                $productosParaEstePedido = [];

                foreach($prodactivelist as $set){
                    $idP = $set['productId'];
                
                    // Comprobar si el producto está restringido para el código postal
                    $sql = "SELECT COUNT(*) AS count
                    FROM " . _DB_PREFIX_ . "products_cp_code
                    WHERE id_product = " . (int)$idP . "
                    AND cp_code = '" . pSQL($codigoPostal) . "'";

                    $restricted = Db::getInstance()->getValue($sql);

                    //var_dump($restricted);

                    
                    if($restricted == 0 && $set['active'] == 1){
                        array_push($productosParaEstePedido, $set);
                    }
                    
                }

                // Asignar los productos recomendados para este pedido en el arreglo principal
                $productosrecomendados[$pedido->obId] = $productosParaEstePedido;
                
                //END RM #56870
            }

            }} else {
                // Manejar el caso en que no haya pedidos en curso
                echo "No hay pedidos en curso.";
            }


        return $productosrecomendados;
    }

    public function getProductosRecomendados6($id_lang)
    {

        if ($id_lang == 1) {
            $carrousel = Configuration::get('CUSTOMCARROUSELS_6_ES');
        } else {
            $carrousel = Configuration::get('CUSTOMCARROUSELS_6_CA');
        }

        $result = explode(",", $carrousel);
        if ((count($result) > 0) and $result[0] > 0) {
            //Acople
            $pr = array();
            foreach ($result as $value) {
                $nodo['productId'] = $value;
                array_push($pr, $nodo);
            }
            $prodactivelist = CustomOb::getProductosContent($pr, $id_lang);
            $productosrecomendados = [];

            //RM #56870 Quitar productos con restricción de frío en carruseles según cp del cliente
            if (is_array(self::$pedidosencurso) && !empty(self::$pedidosencurso)) {

            foreach (self::$pedidosencurso as $pedido) {
                $codigoPostal = $pedido->shippingAddress->postcode;
                $productosParaEstePedido = [];

                foreach($prodactivelist as $set){
                    $idP = $set['productId'];
                
                    // Comprobar si el producto está restringido para el código postal
                    $sql = "SELECT COUNT(*) AS count
                    FROM " . _DB_PREFIX_ . "products_cp_code
                    WHERE id_product = " . (int)$idP . "
                    AND cp_code = '" . pSQL($codigoPostal) . "'";

                    $restricted = Db::getInstance()->getValue($sql);

                    //var_dump($restricted);

                    
                    if($restricted == 0 && $set['active'] == 1){
                        array_push($productosParaEstePedido, $set);
                    }
                    
                }

                // Asignar los productos recomendados para este pedido en el arreglo principal
                $productosrecomendados[$pedido->obId] = $productosParaEstePedido;
                
                //END RM #56870
            }

            }} else {
                // Manejar el caso en que no haya pedidos en curso
                echo "No hay pedidos en curso.";
            }

        return $productosrecomendados;
    }

    public function getProductosRecomendados7($id_lang)
    {
        if ($id_lang == 1) {
            $carrousel = Configuration::get('CUSTOMCARROUSELS_7_ES');
        } else {
            $carrousel = Configuration::get('CUSTOMCARROUSELS_7_CA');
        }

        $result = explode(",", $carrousel);
        if ((count($result) > 0) and $result[0] > 0) {
            //Acople
            $pr = array();
            foreach ($result as $value) {
                $nodo['productId'] = $value;
                array_push($pr, $nodo);
            }
            $prodactivelist = CustomOb::getProductosContent($pr, $id_lang);
            $productosrecomendados = [];

            //RM #56870 Quitar productos con restricción de frío en carruseles según cp del cliente
            if (is_array(self::$pedidosencurso) && !empty(self::$pedidosencurso)) {

            foreach (self::$pedidosencurso as $pedido) {
                $codigoPostal = $pedido->shippingAddress->postcode;
                $productosParaEstePedido = [];

                foreach($prodactivelist as $set){
                    $idP = $set['productId'];
                
                    // Comprobar si el producto está restringido para el código postal
                    $sql = "SELECT COUNT(*) AS count
                    FROM " . _DB_PREFIX_ . "products_cp_code
                    WHERE id_product = " . (int)$idP . "
                    AND cp_code = '" . pSQL($codigoPostal) . "'";

                    $restricted = Db::getInstance()->getValue($sql);

                    //var_dump($restricted);

                    
                    if($restricted == 0 && $set['active'] == 1){
                        array_push($productosParaEstePedido, $set);
                    }
                    
                }

                // Asignar los productos recomendados para este pedido en el arreglo principal
                $productosrecomendados[$pedido->obId] = $productosParaEstePedido;
                
                //END RM #56870
            }

            }} else {
                // Manejar el caso en que no haya pedidos en curso
                echo "No hay pedidos en curso.";
            }


        return $productosrecomendados;
    }
    public static function getProductsForSearch($id_lang)
    {
        if ($id_lang == 1) {
            $carrousel = Configuration::get('CUSTOMCARROUSELS_4_ES');
        } else {
            $carrousel = Configuration::get('CUSTOMCARROUSELS_4_CA');
        }

        $result = explode(",", $carrousel);
        if (isset($result)) {
            foreach ($result as $value) {
                $pr[] = [
                    'productId' => $value,
                ];
            }

            $prodactivelist = CustomOb::getProductosContent($pr, $id_lang);
            $productosrecomendados = [];

            //RM #56870 Quitar productos con restricción de frío en carruseles según cp del cliente
            foreach (self::$pedidosencurso as $pedido) {
                $codigoPostal = $pedido->shippingAddress->postcode;
                $productosParaEstePedido = [];

                foreach($prodactivelist as $set){
                    $idP = $set['productId'];
                
                    // Comprobar si el producto está restringido para el código postal
                    $sql = "SELECT COUNT(*) AS count
                    FROM " . _DB_PREFIX_ . "products_cp_code
                    WHERE id_product = " . (int)$idP . "
                    AND cp_code = '" . pSQL($codigoPostal) . "'";

                    $restricted = Db::getInstance()->getValue($sql);

                    //var_dump($restricted);

                    
                    if($restricted == 0 && $set['active'] == 1){
                        array_push($productosParaEstePedido, $set);
                    }
                    
                }

                // Asignar los productos recomendados para este pedido en el arreglo principal
                $productosrecomendados[$pedido->obId] = $productosParaEstePedido;
                
                //END RM #56870
            }

        }
        return $productosrecomendados;
    }

}