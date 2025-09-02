<?php

class OrderDetail extends OrderDetailCore
{

    protected $webserviceParameters = [
        'fields' => [
            'id_order' => ['xlink_resource' => 'orders'],
            'product_id' => ['xlink_resource' => 'products'],
            'product_attribute_id' => ['xlink_resource' => 'combinations'],
            'product_quantity_reinjected' => [],
            'group_reduction' => [],
            'discount_quantity_applied' => [],
            'download_hash' => [],
            'download_deadline' => [],
        ],
        'hidden_fields' => ['tax_rate', 'tax_name'],
        'associations' => [
            'taxes' => ['resource' => 'tax', 'getter' => 'getWsTaxes', 'setter' => false,
                'fields' => ['id' => []],
            ],
            'customCarts' => ['resource' => 'customCartsOrder', 'getter' => 'getWscustomCarts','setter' => false, 'virtual_entity' => true,
                'fields' => [
                    'id' => [],
                    'id_order' => ['required' => false, 'xlink_resource' => 'orders'],
                    'cesta' => ['required' => false, 'xlink_resource' => 'products'],
                    'componente' => ['required' => false, 'xlink_resource' => 'products'],
                    'alternativo' => ['setter' => false],
                    'name' => ['setter' => false],
                    'date_add' => ['setter' => false],
                    'date_upd' => ['setter' => false],
                ], ],
        ],
    ];

    public function getWscustomCarts()
    {
        $query = '
            SELECT
            `id` as `id`,
            `id_order_detail`,
            `id_order`,
            `cesta`,
            `componente`,
            `alternativo`,
            `intercambiable`,
            `name`,
            `date_add`,
            `date_upd` 
            FROM `' . _DB_PREFIX_ . 'customcarts_order_detail`  
            WHERE id_order_detail = ' . (int) $this->id;
        $result = Db::getInstance()->executeS($query);

        return $result;
    }
}