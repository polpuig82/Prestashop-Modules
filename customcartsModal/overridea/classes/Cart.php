<?php
use PrestaShop\PrestaShop\Adapter\AddressFactory;
use PrestaShop\PrestaShop\Adapter\Cache\CacheAdapter;
use PrestaShop\PrestaShop\Adapter\Customer\CustomerDataProvider;
use PrestaShop\PrestaShop\Adapter\Database;
use PrestaShop\PrestaShop\Adapter\Group\GroupDataProvider;
use PrestaShop\PrestaShop\Adapter\Product\PriceCalculator;
use PrestaShop\PrestaShop\Adapter\ServiceLocator;
use PrestaShop\PrestaShop\Core\Cart\Calculator;
use PrestaShop\PrestaShop\Core\Cart\CartRow;
use PrestaShop\PrestaShop\Core\Cart\CartRuleData;
use PrestaShop\PrestaShop\Core\Localization\Exception\LocalizationException;

class Cart extends CartCore
{
    /**
     * Update Product quantity.
     *
     * @param int $quantity Quantity to add (or substract)
     * @param int $id_product Product ID
     * @param int|null $id_product_attribute Attribute ID if needed
     * @param int|false $id_customization Customization ID
     * @param string $operator Indicate if quantity must be increased or decreased
     * @param int $id_address_delivery Delivery Address ID
     * @param Shop|null $shop
     * @param bool $auto_add_cart_rule
     * @param bool $skipAvailabilityCheckOutOfStock
     * @param bool $preserveGiftRemoval
     * @param bool $useOrderPrices
     *
     * @return bool|int Whether the quantity has been successfully updated
     */
    public function updateQty(
        $quantity,
        $id_product,
        $id_product_attribute = null,
        $id_customization = false,
        $operator = 'up',
        $id_address_delivery = 0,
        Shop $shop = null,
        $auto_add_cart_rule = true,
        $skipAvailabilityCheckOutOfStock = false,
        bool $preserveGiftRemoval = true,
        bool $useOrderPrices = false
    ) {
        parent::updateQty($quantity,$id_product,$id_product_attribute,$id_customization,$operator,$id_address_delivery,$shop,$auto_add_cart_rule,$skipAvailabilityCheckOutOfStock,$preserveGiftRemoval,$useOrderPrices);

        include_once(_PS_MODULE_DIR_.'customcarts'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'customCartsCart.php');
        include_once(_PS_MODULE_DIR_.'customcarts'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'customCartsOb.php');
        //Comprobación módulo

        $productoEnCarrito=customCartsCart::exisProductCart($this->id,$id_product);
        if(count($productoEnCarrito)>0)
        {
            //Devolver mensaje textual Puesto que ya tiene uno, debe eliminar el anterior
            return false;

        }

        //




        $id_lang = Context::getContext()->language->id;
        //Añadir a table cart foreach de lo que me viene como gettools json


        //Sacar cuantos elementos tiene este producto

        $numElementos=customCartsOb::getNumProductosCestaDefinida($id_product,$id_lang);


        if(count($numElementos)>0)
        {

            for($i=1;$i<=count($numElementos);$i++)
            {
                $componente=Tools::getValue('ElementoCestaInp'.$i);
                $elemento= customCartsOb::getProductoCestaDefinida($id_product,$componente,$id_lang);
                customCartsCart::insertProductCart($this->id,$id_product,$elemento['componente'],$elemento['alternativo'],$elemento['intercambiable'],$elemento['name']);
            }
        }






    }



}